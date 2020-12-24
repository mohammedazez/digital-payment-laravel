<?php

namespace App\Http\Controllers\Member;

use Auth, Response, Validator, ZenzivaSMS, Cekmutasi, PDF;
use App\User;
use App\AppModel\Bank;
use App\AppModel\Bank_swif;
use App\AppModel\Mutasi;
use App\AppModel\MenuSubmenu;
use App\AppModel\Transaksi;
use App\AppModel\Mutasi_saldobank;
use App\AppModel\Users_validation;
use App\AppModel\Deposit;
use App\AppModel\Setting;
use App\AppModel\SendSMS;
use App\AppModel\SettingOvoTransfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use DB;
use Mail;

class TransferBankController extends Controller
{
    public function __construct()
    {
        $this->settings = Setting::first();
    }
    
    public function index(Request $request)
    {
        $banks = DB::table('bank_swifs')
        ->select('*')
        ->where('status',1)
        ->get()
        ->toArray();
        
        foreach( $banks as $bi => $b )
        {
            $banks[$bi] = [
                'id'    => $b->id,
                'text'  => $b->name
            ];
        }
        
        return view('member.transfer-bank.form', compact('banks'));
    }
    
    public function process(Request $request)
    {
        $this->validate($request,[
            'penerima'         => 'required',
            'pilih_jenis_bank' => 'required',
            'no_rek'           => 'required',
            'nominal'          => 'required',
            'pin'              => 'required',
        ],[
            'penerima.required'         => 'Nama Penerima Transfer tidak boleh kosong',
            'pilih_jenis_bank.required' => 'Bank tidak boleh kosong',
            'no_rek.required'           => 'Nomor Rekening tidak boleh kosong',
            'nominal.required'          => 'Nominal tidak boleh kosong',
            'pin.required'              => 'PIN tidak boleh kosong',
        ]);

        $userCek  = User::where('id',Auth::user()->id)->first();
        if($userCek->status == 0){
            return redirect()->back()->with('alert-error','Maaf Akun anda dinonaktifkan');
        }
        if($userCek->status_saldo == 0){
            return redirect()->back()->with('alert-error','Maaf saldo anda dikunci dan tidak bisa digunakan');
        }
        if( $userCek->pin == $request->pin ){
            $getValidations =  Users_validation::where('user_id', Auth::user()->id)->first();
            if($getValidations == null)
            {
                $message = 'Silakan melakukan validasi terlebih dahulu untuk menggunakan fitur ini.';
                return redirect()->back()->withInput()->with('alert-error', $message);
                
            } elseif($getValidations->status == '0') {
                $message = 'Validasi anda belum di setujui oleh admin, silahkan hubungi admin untuk mempercepat proses';
                return redirect()->back()->withInput()->with('alert-error', $message);
            } else {
                    
                    $nominal_ori    = (int) str_replace(".", "", $request->nominal);
                    
                    if( substr($nominal_ori, -3) != '000' ) {
                        $message = 'Nominal transfer harus dalam kelipatan 1.000, contoh: 10000, 11000, 100000';
                        return redirect()->back()->withInput()->with('alert-error', $message);
                    }
                    
                    $nominal_sum    = $nominal_ori + 3500;
                    $getSaldo       = User::where('id', Auth::user()->id)->first();
                    $saldo_now      = $getSaldo->saldo;
    
                    if($nominal_ori < 50000){
                            $message = 'Minimal Transfer Rp. '.number_format(50000, 0, '.', '.').'';
                            return redirect()->back()->withInput()->with('alert-error', $message);
                    }elseif($nominal_sum > $saldo_now){
                            $message = 'Jumlah Saldo tidak mencukupi Saldo anda saat ini Rp. '.number_format($saldo_now, 0, '.', '.').'';
                            return redirect()->back()->withInput()->with('alert-error', $message);
                    }else{
                        if( date("G") <= 22 && date("G") >= 1 )
                        {
                            DB::beginTransaction();
                            try{
                                $getCodeBank = Bank_swif::find($request->pilih_jenis_bank);
                                
                                if(!$getCodeBank){
                                    return redirect()->back()->withInput()->with('alert-error', 'Bank Tidak ditemukan.');
                                }
        
                                $dataMutasi = Mutasi_saldobank::max('trxid');
                                if($dataMutasi == null){
                                    $trxid = 1;
                                }else{
                                    $trxid = $dataMutasi+1;
                                }
        
                                //insert ke mutasissaldo_bank
                                $simpanMutasiTF              = new Mutasi_saldobank();
                                $simpanMutasiTF->user_id     = Auth::user()->id;
                                $simpanMutasiTF->trxid       = $trxid;
                                $simpanMutasiTF->penerima    = $request->penerima;
                                $simpanMutasiTF->nominal     = $nominal_ori;
                                $simpanMutasiTF->code_bank   = $getCodeBank->code;
                                $simpanMutasiTF->jenis_bank  = $getCodeBank->name;
                                $simpanMutasiTF->no_rekening = $request->no_rek;
                                $simpanMutasiTF->status      = 0;
                                $simpanMutasiTF->note        = 'Transaksi Transfer ke Bank. No.rekening '.$request->no_rek.' ke bank '.$getCodeBank->name.' sebesar '.number_format($nominal_ori, 0, '.', '.').'  Sedang di proses';
                                $simpanMutasiTF->save();
        
        
                                 $potongSaldo1 = $saldo_now - $nominal_ori;
        
                                 //insert ke mutasi
                                 $mutasi = new Mutasi();
                                 $mutasi->user_id = Auth::user()->id;
                                 $mutasi->type = 'debit';
                                 $mutasi->nominal = $nominal_ori;
                                 $mutasi->saldo  = $potongSaldo1;
                                 $mutasi->note  = 'TRANSAKSI Pemindahan Saldo Rp. '.number_format($nominal_ori, 0, '.', '.').' Ke '.$getCodeBank->name.' ('.$getCodeBank->code.') no.rekening '.$request->no_rek.'';
                                 $mutasi->save();
                                 
                                 sleep(2);
                                 
                                 $potongSaldo2 = $potongSaldo1 - 3500;
                                 //insert ke mutasi
                                 $mutasi_admin = new Mutasi();
                                 $mutasi_admin->user_id = Auth::user()->id;
                                 $mutasi_admin->type = 'debit';
                                 $mutasi_admin->nominal = '3500';
                                 $mutasi_admin->saldo  = $potongSaldo2;
                                 $mutasi_admin->note  = 'Biaya Admin Transfer Saldo Ke Bank ID: #'.$mutasi->id.'';
                                 $mutasi_admin->save();
                                
                                 $sisaSaldo = $saldo_now - $nominal_sum;
                                 //update saldo
                                 $user = Auth::user();
                                 $user->saldo = $sisaSaldo;
                                 $user->save();
                                
                                DB::commit();
                                
                                $message = 'Transfer Saldo Ke Rekening '.$request->no_rek.' jenis bank '.$getCodeBank->name.' ('.$getCodeBank->code.') nominal Rp. '.number_format($nominal_ori, 0, '.', '.').' sedang di proses.';
                                return redirect()->back()->with('alert-success', $message);
                            }catch(\Exception $e){
                                DB::rollback();
                                $message = 'Transaski gagal, Mohon ulangi!';
                                return redirect()->back()->withInput()->with('alert-error', $message);
                                
                            }
                        }else{
                            $message = 'Transfer Saldo Ke Rekening tidak dapat dilakukan pada pukul 22.00 - 01.00 WIB, silahkan melakukan transfer diluar dari pada jam tersebut.';
                            return redirect()->back()->withInput()->with('alert-error', $message);
                        }
                    }
            }
        }else{
            $message = 'Maaf, Pin anda salah!';
            return redirect()->back()->withInput()->with('alert-error', $message);
        }
    }
    
    public function indexOvo(Request $request)
    {
        $URL_uri = request()->segment(1).'/'.request()->segment(2);
        $datasubmenu2 = MenuSubmenu::getSubMenuOneMemberURL($URL_uri)->first();
        
        $ovoSetting = SettingOvoTransfer::firstOrFail();
        
        $banks = Cekmutasi::ovo()->transferBankList($ovoSetting->phone);
            
        if( $banks->success === true )
        {
            $banks = $banks->data;
        }
        else
        {
            $banks = [];
        }
        
        $s = [];
        foreach($banks as $bank)
        {
            if( preg_match('/ovo/i', $bank->name) ) {
                continue;
            }
            
            $s[] = [
                'id' => $bank->code,
                'text' => $bank->code.' - ' . $bank->name,
                'selected' => (old('bank_code') == $bank->code ? true : false)
                ];
        }
        
        $banks = $s;
            
        return view('member.transfer-bank.form-ovo', compact('banks', 'ovoSetting'));
    }
    
    public function inquiry(Request $request)
    {
        if( $this->settings->status == 0 ){
            return redirect()->back()->with('alert-error', 'Sistem Sedang Maintenance, mohon kesabarannya menunggu.');
        }
        
        if( $this->settings->force_verification == 1 )
        {
            $verification = DB::table('users_validations')
                        ->select('*')
                        ->where('user_id', auth()->user()->id)
                        ->first();
        
            if( !$verification )
            {
                return redirect()->back()->with('alert-error', 'Untuk melakukan transaksi ini, akun Anda harus terverifikasi, silahkan lakukan verifikasi <a href="/member/validasi-users" style="font-weight:bold;text-decoration:underline;">DISINI</a> .');
            }
            elseif( $verification->status != '1' )
            {
                return redirect()->back()->with('alert-error', 'Mohon maaf, verifikasi akun Anda masih dalam proses review. Anda belum dapat melakukan transaksi ini');
            }
        }
        
        $this->validate($request, [
            'bank_code' => ['required', 'string'],
            'destination_number' => ['required', 'string', 'regex:/^[0-9]+$/u'],
            'amount' => ['required', 'regex:/^[0-9\.]+$/u'],
            'pin' => ['required', 'string']
            ], [
                'bank_code.required' => 'Silahkan pilih bank tujuan yang valid',
                'destination_number.required' => 'Silahkan masukkan nomor rekening tujuan yang valid',
                'amount.required' => 'Masukkan jumlah transfer',
                'pin.required' => 'PIN tidak boleh kosong',
            ]);

        try
        {
            $currentHour = date("G");
            
            if( $currentHour >= 22 || $currentHour < 1 ) {
                throw new \Exception("Transaksi hanya dapat dilakukan pukul 01.00-22.00 WIB!", __LINE__);
            }
            
            $user = Auth::user();
            $ovoSetting = SettingOvoTransfer::firstOrFail();
            
            $pin = $request->pin;
            $originalAmount = (int) str_replace('.', '', $request->amount);
            
            // if( (substr($originalAmount, -3) != '000') && ($user->roles()->first()->id != 2) ) {
            //     throw new \Exception("Nominal transfer harus dalam kelipatan 1.000, contoh: 10000, 11000, 100000", __LINE__);
            // }
            
            $totalCharge = $originalAmount + 3500;
            $userBalance = $user->saldo;
            
            if( $user->pin != $pin )
            {
                throw new \Exception("PIN yang Anda masukkan salah!", __LINE__);
            }
            elseif( !is_numeric($userBalance) )
            {
                throw new \Exception("Terjadi kesalahan sistem", __LINE__);
            }
            elseif( ($originalAmount < $ovoSetting->min_amount) && ($user->roles()->first()->id != 2) )
            {
                throw new \Exception("Minimal Transfer Rp. " . number_format($ovoSetting->min_amount, 0, '', '.'), __LINE__);
            }
            elseif( $totalCharge > $userBalance )
            {
                throw new \Exception("Jumlah Saldo tidak mencukupi. Saldo anda saat ini Rp. ".number_format($userBalance, 0, '.', '.'), __LINE__);
            }
            
            $inquiry = Cekmutasi::ovo()->transferBankInquiry(
                $ovoSetting->phone,
                $request->bank_code,
                $request->destination_number
                );
            //\Log::info($inquiry);
            if( $inquiry->success != true ) {
                
                if( preg_match('/saldo.*cukup/i', $inquiry->error_message) ) {
                    $inquiry->error_message = 'Layanan sedang gangguan. Silahkan coba lagi 5 menit kedepan atau hubungi Administrator';
                }
                
                throw new \Exception($inquiry->error_message, __LINE__);
            }
            
            $inquiry = $inquiry->data;
            
            return view('member.transfer-bank.inquiry', compact('inquiry', 'originalAmount', 'pin'));
        }
        catch(\Exception $e)
        {
            return redirect('/member/transfer-bank')->with('alert-error', '['.$e->getCode().'] '.$e->getMessage())->withInput();
        }
    }
    
    public function send(Request $request, $uuid)
    {
        $this->validate($request, [
            'token' => ['required', 'string'],
            'amount' => ['required', 'regex:/^[0-9\.]+$/u'],
            'note' => ['required', 'string'],
            'destination_number' => ['required', 'string'],
            'destination_name' => ['required', 'string'],
            'bank_code' => ['required', 'string'],
            'bank_name' => ['required', 'string'],
            'pin' => ['required', 'string']
            ]);
        
        DB::beginTransaction();
        
        try
        {
            $currentHour = date("G");
            
            if( $currentHour >= 22 || $currentHour < 1 ) {
                throw new \Exception("Transaksi hanya dapat dilakukan pukul 01.00-22.00 WIB!", __LINE__);
            }
            
            $user = Auth::user();
            $ovoSetting = SettingOvoTransfer::firstOrFail();
            
            $pin = $request->pin;
            $originalAmount = (int) str_replace('.', '', $request->amount);
            // if( (substr($originalAmount, -3) != '000') && ($user->roles()->first()->id != 2) ) {
            //     throw new \Exception("Nominal transfer harus dalam kelipatan 1.000, contoh: 10000, 11000, 100000", __LINE__);
            // }
            $totalCharge = $originalAmount + 3500;
            $userBalance = $user->saldo;
            
            if( $user->pin != $pin )
            {
                throw new \Exception("PIN yang Anda masukkan salah!", __LINE__);
            }
            elseif( !is_numeric($userBalance) )
            {
                throw new \Exception("Terjadi kesalahan sistem", __LINE__);
            }
            elseif( ($originalAmount < $ovoSetting->min_amount) && ($user->roles()->first()->id != 2) )
            {
                throw new \Exception("Minimal Transfer Rp. " . number_format($ovoSetting->min_amount, 0, '', '.'), __LINE__);
            }
            elseif( $totalCharge > $userBalance )
            {
                throw new \Exception("Jumlah Saldo tidak mencukupi. Saldo anda saat ini Rp. ".number_format($userBalance, 0, '.', '.'), __LINE__);
            }
            
            $dataMutasi = Mutasi_saldobank::max("trxid");
            $trxid = !$dataMutasi ? 1 : ($dataMutasi+1);
            
            //insert ke mutasissaldo_bank
            $simpanMutasiTF              = new Mutasi_saldobank();
            $simpanMutasiTF->user_id     = $user->id;
            $simpanMutasiTF->trxid       = $trxid;
            $simpanMutasiTF->penerima    = $request->destination_name;
            $simpanMutasiTF->nominal     = $originalAmount;
            $simpanMutasiTF->code_bank   = $request->bank_code;
            $simpanMutasiTF->jenis_bank  = $request->bank_name;
            $simpanMutasiTF->no_rekening = $request->destination_number;
            $simpanMutasiTF->status      = 1;
            $simpanMutasiTF->note        = 'Transaksi sukses | UUID: ' . $uuid . ' | Note: ' . $request->note;
            $simpanMutasiTF->save();
            
            $newBalance = $userBalance - $originalAmount;
            
            $mutasi = new Mutasi();
            $mutasi->user_id = $user->id;
            $mutasi->type = 'debit';
            $mutasi->nominal = $originalAmount;
            $mutasi->saldo  = $newBalance;
            $mutasi->note  = 'TRANSAKSI Pemindahan Saldo Rp. '.number_format($originalAmount, 0, '.', '.').' Ke '.$request->bank_name.' ('.$request->bank_code.') no.rekening '.$request->destination_number;
            $mutasi->save();
            
            $newBalance = $newBalance - 3500;
            
            $mutasi_admin = new Mutasi();
            $mutasi_admin->user_id = $user->id;
            $mutasi_admin->type = 'debit';
            $mutasi_admin->nominal = 3500;
            $mutasi_admin->saldo  = $newBalance;
            $mutasi_admin->note  = 'Biaya Admin Transfer Saldo Ke Bank ID: #'.$mutasi->id.'';
            $mutasi_admin->save();
            
            $user->saldo = $newBalance;
            $user->save();
            
            $send = Cekmutasi::ovo()->transferBank($uuid,$request->token,$originalAmount,trim(strip_tags($request->note)));
            //\Log::info($send);
            
            if( $send->success != true )
            {
                if( preg_match('/saldo.*cukup/i', $send->error_message) ) {
                    $send->error_message = 'Layanan sedang gangguan. Silahkan coba lagi 5 menit kedepan atau hubungi Administrator ['.__LINE__.']';
                }
                
                $check = Cekmutasi::ovo()->transferBankDetail([
                    'uuid' => $uuid
                    ]);
                
                if( $check->success == true )
                {
                    if( $check->data->status != 'success' )
                    {
                        throw new \Exception($send->error_message, __LINE__);
                    }
                    else
                    {
                        $send->success = true;
                        $send->data = $check->data;
                    }
                }
                else
                {
                    throw new \Exception($send->error_message, __LINE__);
                }
            }
            
            DB::commit();
            
            return redirect('/member/transfer-bank')->with('alert-success', 'Transaksi Anda berhasil diproses! Lihat detail transaksi <a target="_blank" href="'.url('/member/transfer-bank/history/show/' . $simpanMutasiTF->id).'">DISINI</a>');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            
            return redirect('/member/transfer-bank')->with('alert-error', '['.$e->getCode().'] '.$e->getMessage() .' | Pastikan melakukan pengecekan riwayat transfer & saldo sebelum mengulangi transaksi')->withInput();
        }
    }
    
    public function history()
    {
        $transaksisMobile = Mutasi_saldobank::where('user_id', Auth::user()->id)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(10);

        return view('member.transfer-bank.history', compact('transaksisMobile'));
    }
    
    public function historyDatatables()
    {
            $data = Mutasi_saldobank::where('user_id', Auth::user()->id)
                        ->orderBy('created_at', 'DESC')
                        ->get();
            
             return DataTables::collection($data)

             ->editColumn('id',function($data){
                    return '#'.$data->id.'';
             })

             ->editColumn('nominal',function($data){
                    return '<td><span class="label label-info">Rp. '.number_format($data->nominal, 0, '.', '.').'</span></td>';
             })
                        
             ->editColumn('created_at',function($data){
                    return Carbon::parse($data->created_at)->format('d-m-Y H:i:s');
             })

             ->editColumn('status',function($data){
                if($data->status == 0){
                    return '<td><span class="label label-warning">PROSES</span></td>';
                }elseif($data->status == 1){
                    return '<td><span class="label label-success">BERHASIL</span></td>';
                }elseif($data->status == 2){
                    return '<td><span class="label label-danger">GAGAL</span></td>';
                }elseif($data->status == 3){
                    return '<td><span class="label label-primary">REFUND</span></td>';
                };
            })
            
             ->editColumn('action_print',function($data){
                    return '<td><a href="'.url('/member/transfer-bank/history/print', $data->id).'" class="btn-loading btn btn-primary btn-sm" style="padding: 2px 5px;font-size:10px;" target="_blank">Print Struk</i></a></td>';
             })
                
             ->editColumn('action_detail',function($data){
                    return '<td><a href="'.url('/member/transfer-bank/history/show', $data->id).'" class="btn-loading btn btn-primary btn-sm" style="padding: 2px 5px;font-size:10px;">Detail</i></a></td>';
             })

             ->rawColumns(['id','nominal','created_at','status','action_print','action_detail'])
             ->make(true);
    }
    
    public function show(Request $request, $id ='')
    {
        $transaksi = DB::table('mutasisaldo_bank')
                ->select('mutasisaldo_bank.*','users.name')
                ->leftjoin('users','mutasisaldo_bank.user_id','users.id')
                ->where('mutasisaldo_bank.id', $id)
                ->orderBy('mutasisaldo_bank.created_at','DESC')
                ->first();
                
        return view('member.transfer-bank.show', compact('transaksi'));
    }
    
    public function printStruk($id)
    {
        $transaksi = DB::table('mutasisaldo_bank')
            ->select('mutasisaldo_bank.*','users.name')
            ->leftjoin('users','mutasisaldo_bank.user_id','users.id')
            ->where('mutasisaldo_bank.id', $id)
            ->first();
        $user            = User::where('id',$transaksi->user_id)->first();
        $GeneralSettings = $this->settings;
        
        $pdf             = new PDF();
        $customPaper     = array(0,0,200,250);
        $pdf             = PDF::loadView('member.transfer-bank.print', compact('transaksi','user','GeneralSettings'))->setPaper($customPaper);
       
        $SavePrintName = 'trf'.strtolower($transaksi->id).'_'. date('d-m-Y_H:i:s').'';
        return $pdf->stream(''.$SavePrintName.'.pdf',array("Attachment"=>0));
    }
    
    public function getBankCode(Request $request)
    {
        $params = [
            'search_text' => $request->input('q'),
        ];

        $data = DB::table('bank_swifs')
            ->select('*')
            ->where(DB::raw('lower(name)'), 'like','%'.strtolower((isset($params['search_text'])?$params['search_text']:'')).'%')
            ->orWhere(DB::raw('lower(code)'), 'like','%'.strtolower((isset($params['search_text'])?$params['search_text']:'')).'%')
            ->get();

        $results=[];
        foreach ($data as $key ) {
            $results[] = [
              'id'     => $key->id,
              'text'   => $key->code.' - '.$key->name,

            ];
        }
        return $results;
    }
}