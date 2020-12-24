<?php

namespace App\Http\Controllers\Member;

use Auth;
use App\User;
use App\Role;
use App\AppModel\Voucher;
use App\AppModel\Redeem;
use App\AppModel\Mutasi;
use App\AppModel\Transaksi;
use App\AppModel\Users_validation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class RedeemController extends Controller
{
    public function redeemVoucher(Request $request)
    {
        $this->validate($request,[
            'kode_voucher' => 'required',
        ],[
            'kode_voucher.required' => 'Koden Voucher tidak boleh kosong',
        ]);
        
        $code    = $request->kode_voucher;
        $voucher = Voucher::where('code', $code)->first();
        if($voucher != null){
            if($voucher->code == $code){
                $user              = User::where('id', Auth::user()->id)->first();
                $userValidation    = Users_validation::where('user_id', Auth::user()->id)->where('status', 1)->count();
                if($voucher->filter_datereg_user != 0){
                    // ..
                    $date_user = strtotime(date($user->created_at));
                    $date_filter = strtotime(date($voucher->value_datereg_user));
                    
                    if($date_user > $date_filter){
                        return redirect()->back()->with('alert-error', 'Kode Voucher tidak berlaku untuk anda, hanya untuk member yang terdaftar sebelum '. Carbon::parse($voucher->value_datereg_user)->format('d M Y') .'');
                    }
                }
                
                if($voucher->filter_verified != 0){
                    if($voucher->value_verified == 'verification')
                    {
                        if($userValidation == 0){
                            return redirect()->back()->with('alert-error', 'Kode Voucher tidak berlaku untuk anda, hanya untuk member yang terverifikasi');
                        }
                    }else{
                        if($userValidation == 1){
                            return redirect()->back()->with('alert-error', 'Kode Voucher tidak berlaku untuk anda, hanya untuk member yang tidak terverifikasi');
                        }
                    }
                }
                
                if($voucher->filter_saldo != 0){
                    if( $user->saldo < $voucher->value_saldo){
                        return redirect()->back()->with('alert-error', 'Kode Voucher tidak berlaku untuk anda, hanya untuk member yang minimal saldo Rp. '.number_format($voucher->value_saldo, 0,'.','.').'');
                    }
                }
            
                if($voucher->filter_saldo_max != 0){
                    if( $user->saldo > $voucher->value_saldo_max){
                        return redirect()->back()->with('alert-error', 'Kode Voucher tidak berlaku untuk anda, hanya untuk member yang maximal saldo Rp. '.number_format($voucher->value_saldo_max, 0,'.','.').'');
                    }
                }
                
                if($voucher->filter_level_user != 0){
                    if($voucher->value_level_user != Auth::user()->roles()->first()->id)
                    {
                        return redirect()->back()->with('alert-error', 'Kode Voucher tidak berlaku untuk anda, hanya untuk member yang berlevel '.Role::find($voucher->value_level_user)->display_name.'');
                    }
                }
                
                $transaksi = Transaksi::where('user_id', Auth::user()->id)->count();
                // if($transaksi > 0){
                    if($voucher != null and $voucher->qty != 0){
                        $redeems = Redeem::where('user_id', Auth::user()->id)->where('voucher_id', $voucher->id)->first();
                        if( !$redeems )
                        {
                            $user = User::findOrFail(Auth::user()->id);
                            $sisaSaldo = $user->saldo + $voucher->bonus;
                            $user->saldo = $sisaSaldo;
                            $user->save();
                            
                            $mutasi = new Mutasi();
                            $mutasi->user_id = $user->id;
                            $mutasi->type = 'credit';
                            $mutasi->nominal = $voucher->bonus;
                            $mutasi->saldo  = $sisaSaldo;
                            $mutasi->note  = 'REDEEM VOUCHER RP'.$voucher->bonus.' BERHASIL';
                            $mutasi->save();
                            
                            $redeem = new Redeem();
                            $redeem->user_id = Auth::user()->id;
                            $redeem->voucher_id = $voucher->id;
                            $redeem->save();
                            
                            $qty = $voucher->qty - 1;
                            $use = $voucher->use_kupon + 1;
                            $voucher->qty = $qty;
                            $voucher->use_kupon = $use;
                            if($qty == 0){
                                $voucher->status = 0;
                            }
                            $voucher->save();
                                
                                return redirect()->back()->with('alert-success', 'REDEEM VOUCHER dengan Kode voucher '.$code.' BERHASIL. Anda mendapatkan BONUS SALDO sebesar Rp '.number_format($voucher->bonus, 0,'.','.'));
                            }else{
                                return redirect()->back()->with('alert-error', 'Anda sudah pernah melakukan redeem voucher dengan kode voucher '.$code.' pada tanggal '.$redeems->created_at);
                            }
                            
                        }else{
                            return redirect()->back()->with('alert-error', 'Voucher tidak tersedia, periksa kembali kode voucher anda');
                        }
                    // }else{
                    //     return redirect()->back()->with('alert-error', 'Akun anda tidak memenuhi syarat untuk melakukan Redeem Voucher');
                    // }
                      
            }else{
                return redirect()->back()->with('alert-error', 'Kode Voucher tidak cocok, periksa kambali kode voucher anda');
            }
        }else{
            return redirect()->back()->with('alert-error', 'Kode Voucher tidak cocok, periksa kambali kode voucher anda');
        }
    }
}
