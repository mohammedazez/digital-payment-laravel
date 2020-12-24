<?php

namespace App\Http\Controllers\Member;

use DB, Exception, Cekmutasi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AppModel\PayPalModel;
use App\User;
use App\AppModel\Deposit;
use App\AppModel\Mutasi;
use App\AppModel\Bank;
use App\AppModel\SMSGateway;
use Carbon\Carbon;
use App\AppModel\Setting;

class PayPalController extends Controller
{
    public function view(Request $request, $id)
    {
        $user = $request->user();
        $pp = PayPalModel::where('user_id', $user->id)->findOrFail($id);
        $deposit = Deposit::findOrFail($pp->deposit_id);
        $bank = $deposit->bank;
        
        if( in_array($pp->status, [0,1]) && $pp->expired_at->lte(Carbon::now()) )
        {
            DB::beginTransaction();
            
            try
            {
                $pp->status = 3;
                $wp->note = 'Transaksi Kadaluarsa';
                $wp->save();
                
                $deposit->status = 2;
                $deposit->expire = 0;
                $deposit->note = 'Transaksi Kadaluarsa';
                $deposit->save();
                
                DB::commit();
            }
            catch(Exception $e)
            {
                DB::rollBack();
                    
                if( $e instanceof \Illuminate\Database\QueryException ) {
                    \Log::error($e);
                }
                
                return $e->getMessage();
            }
        }
        
        return view('member.paypal.view', compact('pp', 'deposit', 'bank', 'user'));
    }
    
    public function callback()
    {
        return redirect()->url('/deposit');
    }
    
    public function confirm(Request $request, $id)
    {
        $v = \Validator::make($request->all(), [
            'email' => ['required', 'email']
            ]);
            
        if( $v->fails() ) {
            return redirect()->back()->with('alert-error', 'Email tidak valid!');
        }
        
        $user = $request->user();
        
        if( $request->email != $user->paypal_email ) {
            return redirect()->back()->with('alert-error', 'Email pengirim harus sesuai dengan email paypal yang terdaftar di profil');
        }
        
        $setting = Setting::first();
        $pp = PayPalModel::where('user_id', $user->id)->findOrFail($id);
        $deposit = Deposit::findOrFail($pp->deposit_id);
        $bank = $deposit->bank;
        
        $pp->update([
            'payer_email'   => $request->email,
            'status'        => 1
            ]);
            
        if( !$pp ) {
            return redirect()->back()->with('alert-error', 'Terjadi kesalahan. Silahkan diulangi atau hubungi Administrator');
        }
        
        $cm = Cekmutasi::paypal_search([
            'date'      => [
                'from'  => date('Y-m-d').' 00:00:00',
                'to'    => date('Y-m-d').' 23:59:59'
                ],
            'username'  => $bank->code,
            'amount'    => $pp->amount_usd,
            'email'     => $request->email,
            'currency'  => 'USD'
            ]);
        
        $mutasi = json_decode($cm, true);
        
        if( $mutasi['success'] === true && count($mutasi['response']) > 0 )
        {
            foreach($mutasi['response'] as $i => $data)
            {
                if( $i == 4 ) {
                    break;
                }
                
                $amount = number_format($data['amount'], 2, ".", "");
                $net = number_format($data['net'], 2, ".", "");
                $status = $data['status'];
                $transactionid = $data['transactionid'];
                $time = $data['unix_timestamp'];
                $type = $data['type'];
                $email = $data['email'];
                
                if( ($data['username'] == $bank->code) && ($type == 'payment') && ($email == $request->email) )
                {
                    $dt = Cekmutasi::paypal_detail([
                        'username'  => $bank->code,
                        'transactionid' => $transactionid
                        ]);
                        
                    $detail = json_decode($dt, true);
                    
                    if( $detail['success'] === true && count($detail['response']) > 0 )
                    {
                        $res = $detail['response'];
                        
                        if( strtolower($res['ACK']) == 'success' && isset($res['NOTE'], $res['AMT'], $res['PAYMENTSTATUS'], $res['TRANSACTIONID'], $res['EMAIL']) )
                        {
                            $note = strtoupper($res['NOTE']);
                            $jmlh = $res['AMT'] - floatval(isset($res['FEEAMT']) ? $res['FEEAMT'] : 0);
                            
                            if( (stripos(strtoupper($pp->note), $note) !== false) && ($jmlh == $pp->amount_usd) && ($res['TRANSACTIONID'] == $transactionid) )
                            {
                                if( strtolower($res['EMAIL']) == strtolower($user->paypal_email) )
                                {
                                    switch(strtolower($res['PAYMENTSTATUS']))
                                    {
                                        case 'completed':
                                            DB::beginTransaction();
                                            
                                            try
                                            {
                                                // user
                                                $user = User::findOrFail($deposit->user_id);
                                                $saldo = $user->saldo + $deposit->nominal_trf;
                                                $user->saldo = $saldo;
                                                $user->save();
                        
                                                $deposit->status = 1; // sukses
                                                $deposit->expire = 0;
                                                $deposit->note = 'Deposit sebesar Rp '.number_format($deposit->nominal_trf, 0, '.', '.').' berhasil ditambahkan, saldo sekarang Rp '.number_format($saldo, 0, '.', '.').'.';
                                                $deposit->save();
                        
                                                $mutasi = new Mutasi();
                                                $mutasi->user_id = $user->id;
                                                $mutasi->trxid = $deposit->id;
                                                $mutasi->type = 'credit';
                                                $mutasi->nominal = $deposit->nominal_trf;
                                                $mutasi->saldo  = $saldo;
                                                $mutasi->note  = 'DEPOSIT/TOP-UP SALDO via '.$bank->nama_bank;
                                                $mutasi->save();
                                                
                                                $pp->update([
                                                    'status'        => 2,
                                                    'transaction_id' => $transactionid,
                                                    'payment_time'  => Carbon::now()->format('Y-m-d H:i:s'),
                                                    // 'additional_info' => json_encode($res)
                                                    ]);
                                                
                                                DB::commit();
                                                
                                                SMSGateway::send($user->phone, 'Yth. '.$user->name.', deposit Rp '.number_format($deposit->nominal_trf, 0, '.', '.').' SUKSES via '.$bank->nama_bank.'. Saldo akhir: Rp '.number_format($saldo, 0, '.', '.').' ~ '.$setting->nama_sistem);
                                            }
                                            catch(Exception $e)
                                            {
                                                DB::rollback();
                                            }
                                            
                                            break;
                                        
                                        case 'pending':
                                        case 'underreview':
                                            DB::beginTransaction();
                                            
                                            try
                                            {
                                                $pp->update([
                                                    'status' => 4, // hold
                                                    'additional_info' => 'Pembayaran sedang dalam review PayPal'
                                                    ]);
                                                
                                                DB::commit();
                                            }
                                            catch(Exception $e)
                                            {
                                                DB::rollback();
                                            }
                                            break;
                                            
                                        default:
                                            
                                            break;
                                    }
                                    
                                }
                                else
                                {
                                    DB::beginTransaction();
                                            
                                    try
                                    {
                                        $pp->update([
                                            'status' => 4, // hold
                                            'additional_info' => 'Email PayPal pengirim tidak terdaftar di profil'
                                            ]);
                                        
                                        DB::commit();
                                    }
                                    catch(Exception $e)
                                    {
                                        DB::rollback();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
        return redirect()->back()->with('alert-success', 'Konfirmasi diterima. Pembayaran sedang dalam pengecekan sistem');
    }
}