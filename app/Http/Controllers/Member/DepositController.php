<?php

namespace App\Http\Controllers\Member;

use Auth, Response, Validator;
use App\User;
use App\AppModel\Bank;
use App\AppModel\Bank_kategori;
use App\AppModel\Provider;
use App\AppModel\PaypalModel;
use App\AppModel\Mutasi;
use App\AppModel\Deposit;
use App\AppModel\Transaksi;
use App\AppModel\Setting;
use App\AppModel\Kurs;
use App\AppModel\CoinPaymentsModel;
use App\AppModel\MenuSubmenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\AppModel\SMSGateway;
use App\AppModel\BlockPhone;
use DB;
use Log;

class DepositController extends Controller
{
    public function __construct()
    {
        $this->settings = Setting::first();
    }
    
    public function formDeposit()
    {
        $URL_uri = request()->segment(1).'/'.request()->segment(2);
        $datasubmenu2 = MenuSubmenu::getSubMenuOneMemberURL($URL_uri)->first();

        if($datasubmenu2->status_sub != 0 )
        {   
            $banks_kategori = Bank_kategori::orderby('urutan', 'ASC')->get();
        	$banks = Bank::where('status','1')->get();
        	$depositsWeb = Deposit::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        	$depositsMobile = $depositsWeb;
            
    	    return view('member.deposit.form', compact('banks', 'depositsWeb', 'depositsMobile','banks_kategori'));
        }
        else
        {
            abort(404);
        }
    }

    public function getbankDeposit(Request $request)
    {
        $getbankCategory = Bank_kategori::where(['id'=>$request->id_category_bank,'status'=>1])->get();
        $getbank = Bank::where('bank_kategori_id',$request->id_category_bank)->where('status',1)->orderBy('updated_at','DESC')->get();
        if(empty($getbankCategory)){
            return response()->json([
                'success'=>false,
                'message'=>'Mohon Maaf, Jenis Pembayaran <b>'.$getbankCategory->paymethod.'</b> belom tersedia untuk saat ini!',
            ],200);
        }
        
        if($request->id_category_bank == '2')
        { 
            return response()->json([
                'succes'=>true ,
                'message'=>'data ditemukan!',
                'data'=>'2',
            ],200);
        }
        else
        {
              return response()->json([
                  'success' => true,
                  'message' => 'data ditemuakan!',
                  'data'    => $getbank,
              ], 200);
        }
    }

    public function depositsaldo(Request $request)
    {
        $this->validate($request,[
            'bank_id'          => 'required',
            'id_category_bank' => 'required',
            'nominal'          => 'required|regex:/^[0-9\.]+$/i',
        ],[
            'bank_id.required'          => 'Bank boleh kosong',
            'id_category_bank.required' => 'Kategori Bank tidak boleh kosong',
            'nominal.required'          => 'Nominal tidak boleh kosong',
        ]);
        
        if( $this->settings->status == 0 ) {
            return redirect()->back()->with('alert-error', 'Sistem Sedang Maintenance, mohon kesabarannya menunggu.');
        }

        if(($request->input('id_category_bank') == '') || ($request->input('id_category_bank') != '2' && $request->input('bank_id') == '')){
            return redirect()->back()->with('alert-error', 'Pilih terlebih dahulu jenis pembayaran yang ingin anda gunakan.!');
        }
        
        $getbank = Bank::find($request->bank_id);
        if($getbank == null || empty($getbank)){
            return redirect()->back()->withErrors('alert-error','Data Bank tidak Ditemukan');
        }

        $getkategoribank = Bank_kategori::find($getbank->bank_kategori_id);
        if($getkategoribank == null || empty($getkategoribank)){
            return redirect()->back()->with('alert-error','Data Kategori Bank Tidak Ditemukan');
        }

        $provider = Provider::find($getbank->provider_id);
        if($provider == null || empty ($provider)){
            return redirect()->back()->with('alert-error','Data Kategori Bank tidak ditemukan');
        }

        $userCek  = User::where('id',Auth::user()->id)->first();
        if($userCek->status == 0){
            return redirect()->back()->with('alert-error','Maaf Akun anda dinonaktifkan');
        }
        $cekPhone = BlockPhone::getDataPhoneWhere($userCek->phone);
        $rolesId = $userCek->roles()->first()->id;
        if( !$cekPhone )
        {
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
                        
            $nominal = str_replace(".", "", $request->nominal);
            $nominal_trf = str_replace(".", "", $request->nominal) + intval($this->settings->deposit_fee);
            $getData = Deposit::getMinDeposit();
            
            
            if( $nominal < $getData[0]->minimal_nominal )
            {
                return redirect()->back()->with('alert-error', 'Minimal Deposit Rp. '.number_format($getData[0]->minimal_nominal, 0, '.', '.').'');
            }
            elseif( substr($nominal, -3) !== '000' )
            {
                return redirect()->back()->with('alert-error', 'Deposit harus dengan nominal kelipatan 1000, misal : 50000, 51000, 100000, dst');
            }
            else
            {
                if(Auth::user()->roles()->first()->id == 1){
                    if( $this->settings->max_daily_deposit_personal > 0 )
                    {
                        $dailyDepositRequest = (int) Deposit::where('user_id', Auth::id())->whereDate('created_at', date('Y-m-d'))->whereIn('status', [0,1])->count();
                        
                        if( $dailyDepositRequest >= $this->settings->max_daily_deposit_personal )
                        {
                            return redirect()->back()->with('alert-error', 'Anda sudah mencapai batas maksimum request deposit harian!');
                        }
                    }
                }else if(Auth::user()->roles()->first()->id == 3){
                    if( $this->settings->max_daily_deposit_agen > 0 )
                    {
                        $dailyDepositRequest = (int) Deposit::where('user_id', Auth::id())->whereDate('created_at', date('Y-m-d'))->whereIn('status', [0,1])->count();
                        
                        if( $dailyDepositRequest >= $this->settings->max_daily_deposit_agen )
                        {
                            return redirect()->back()->with('alert-error', 'Anda sudah mencapai batas maksimum request deposit harian!');
                        }
                    }
                }else if(Auth::user()->roles()->first()->id == 4){
                    if( $this->settings->max_daily_deposit_enterprise > 0 )
                    {
                        $dailyDepositRequest = (int) Deposit::where('user_id', Auth::id())->whereDate('created_at', date('Y-m-d'))->whereIn('status', [0,1])->count();
                        
                        if( $dailyDepositRequest >= $this->settings->max_daily_deposit_enterprise )
                        {
                            return redirect()->back()->with('alert-error', 'Anda sudah mencapai batas maksimum request deposit harian!');
                        }
                    }
                }
              
                if($provider->name == 'CoinPayment')
                {
                    DB::beginTransaction();
                    
                    try
                    {
                        $deposit = new Deposit();
                        $deposit->bank_id = $getbank->id;
                        $deposit->bank_kategori_id = $getbank->bank_kategori_id;
                        $deposit->code_unik = 0;
                        $deposit->nominal = $nominal;
                        $deposit->nominal_trf = $nominal_trf;
                        $deposit->note = "Menunggu pembayaran sebesar Rp ".number_format($nominal, 0, '.', '.');
                        $deposit->user_id = Auth::user()->id;
                        $deposit->save();
                        
                        $deposit->payment_url = url('/member/deposit/coinpayments/'.$deposit->id);
                        $deposit->save();
                        
                        DB::commit();
                        
                        return redirect()->to('/member/deposit/coinpayments/'.$deposit->id);
                    }
                    catch(\Exception $e)
                    {
                        DB::rollback();
                        return redirect()->back()->with('alert-error','Deposit Gagal');
                    }
                }
                
                if($provider->name == 'CekMutasi' || $provider->id == 6)
                {
                     if( (date("G") < 21 && date("G") >= 3) )
                     {
                        
                        $code_unik = mt_rand(1, 999);
                        if( substr($code_unik, -1) == "0" )
                        {
                            $code_unik = $code_unik + mt_rand(1,9);
                        }
                        
                        $nominal_trf = (intval($nominal_trf) + intval($code_unik));
                     
                        for($i=1; $i>=1; $i++)
                        {
                            $check = (int) Deposit::where('nominal_trf', $nominal_trf)->whereDate('created_at', date('Y-m-d'))->whereIn('status', [0,1,3])->count();
                         
                            if( $check <= 0 )
                            {
                                break;
                            }
                            else
                            {
                                $code_unik++;
                                $nominal_trf++;
                               
                            }
                        }
                        DB::beginTransaction();
                        try{
                            $deposit = new Deposit();
                            $deposit->bank_id = $getbank->id;
                            $deposit->bank_kategori_id = $getbank->bank_kategori_id;
                            $deposit->code_unik = $code_unik;
                            $deposit->nominal = $nominal;
                            $deposit->nominal_trf = $nominal_trf;
                            $deposit->note = "Menunggu pembayaran sebesar Rp ".number_format($nominal_trf, 0, '.', '.');
                            $deposit->user_id = Auth::user()->id;
                            $deposit->save();
                           
                            DB::commit();
                            return redirect()->to('/member/deposit/'.$deposit->id);
                        }catch(\Exception $e){
                            DB::rollback();
                            return redirect()->back()->with('alert-error','Deposit Gagal');
                        }
                    }
                    else
                    {
                        return redirect()->back()->with('alert-error', 'Deposit tidak dapat dilakukan pada pukul 21.00 - 03.00 WIB, silahkan melakukan deposit diluar dari pada jam tersebut.');
                    }
                }
                
                if($provider->name == 'PaymentTripay'){
                    DB::beginTransaction();
                    try{
                        $username = $userCek->name;
                        $Useremail = $userCek->email;
                        $Userphone = $userCek->phone;
                        
                        $apikey =  $provider->api_key; //isi dengan PaymentTripay ApiKey Anda
                        $privateKey = $provider->private_key; // isi dengan PaymentTripay PrivateKey Anda
                        $merchantCode = $provider->merchant_code; // isi dengan PaymentTripay MerchantCode Anda
                        $expiredTime = (time()+(24*60*60));
                        $paymentMethod = $getbank->code;

                        if($paymentMethod == "BBBA"){
                            $paymentMethod= "PERMATAVA";
                        }else if($paymentMethod == 'BNIN'){
                            $paymentMethod = 'BNIVA';
                        }else if($paymentMethod == 'IBBK'){
                            $paymentMethod = 'MYBVA';
                        }else if($paymentMethod == 'BRIN'){
                            $paymentMethod = 'BRIVA';
                        }else if($paymentMethod == 'BMRI'){
                            $paymentMethod= 'MANDIRIVA';
                        }

                        $deposit                   = new Deposit();
                        $deposit->bank_id          = $getbank->id;
                        $deposit->bank_kategori_id = $getbank->bank_kategori_id;
                        $deposit->code_unik        = 0;
                        $deposit->nominal          = $nominal;
                        $deposit->nominal_trf      = $nominal_trf;
                        $deposit->note             = "Menunggu pembayaran sebesar Rp ".number_format($nominal, 0, '.', '.');
                        $deposit->user_id          = $userCek->id;
                        $deposit->save(); 
                        $data = $this->data($nominal_trf,$paymentMethod,$username,$Useremail,$Userphone,$merchantCode,$deposit->id,$privateKey,$expiredTime);
              
                        return $this->paymenttripay($deposit,$apikey,$data);   
                    }catch(\Exception $e){
                        \Log::error($e);
                        DB::rollback();
                        return redirect()->back()->with('alert-error', 'Terjadi Kesalahan');
                    }
                }
                if($provider->name == 'Paypal'){
                    if(empty($userCek->paypal_email)){
                        return redirect()->back()->with('alert-error','Silahkan lengkapi informasi rekening paypal di profil Anda terlebih dahulu');
                    }
                    $today = Carbon::today();
                    $totalInDay = (int)PaypalModel::where('user_id',$userCek->id)->where('action','deposit')->whereBetween('created_at',[$today->format('Y-m-d H:i:s'),$today->addHours(24)->format('Y-m-d H:i:s')])->sum('amount_idr');
                    $limit = $rolesId == 4 ? 5000000 : 1000000;

                    if($nominal_trf > $limit)
                    {
                        return redirect()->back()->with('alert-error','Maksimum akumulasi total deposit via PaypAL DALAM 24 jam adalah Rp. '.number_format($limit,0,'.','.'));
                    }
                    elseif(($totalInDay+$nominal_trf) > $limit)
                    {
                        return redirect()->back()->with('alert-error','Maksimum akumulasi jumlah total deposit via PayPal dalam 24 jam adalah Rp. '.number_format($limit,0,'.','.').'. Anda telah melakukan deposit PayPal sebesar Rp. '.number_format($totalInDay,0,'.','.'));
                    }
                    return $this->paypalPayment($request);
                }
                return redirect()->back()->with('alert-error', 'Gagal Diproses!.');
            }
        }
        else
        {
            return redirect()->back()->with('alert-error', 'Maaf, No.Hp Anda Diblokir!');
        }
    }
    
    public function showDeposit($id)
    {
        $banks = Bank::all();
        $deposits = Deposit::where('user_id', Auth::user()->id)->findOrFail($id);
        return view('member.deposit.show', compact('deposits', 'banks'));
    }
    
    public function konfirmasiPembayaran(Request $request)
    {   
        
        //try{
            $validator = Validator::make($request->all(),[
                    'bukti' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                ],[
                    'bukti.required'      => 'Bukti pembayaran tidak boleh kosong',
                    'bukti.image'         => 'Bukti pembayaran harus berformat gambar',
                    'bukti.mimes'         => 'Bukti pembayaran harus dalam format png, jpg, atau jpeg',
                    'bukti.max'           => 'Bukti pembayaran Max Size 5MB',
                ]);
            if($validator->fails()){
                return redirect()->back()->with('alert-error',$validator->errors()->first());
            }
           
            $bukti = $request->file('bukti');
            $extension = $bukti->getClientOriginalExtension();
            if(!in_array($extension,['png','jpeg','jpg'])){
                return redirect()->back()->with('alert-error','Format File yang anda upload tidak didukung');
            }
           
            $nameBukti      = 'bukti_'.$request->id.time().'.'.strtolower($bukti->getClientOriginalExtension());
          
            $extension = $bukti->getClientOriginalExtension();
            
            if(!in_array($extension,['png','jpg','jpeg'])){
                return redirect()->back()->with('alert-error','Format Bukti Pembayaran yang anda upload tidak didukung!');
            }
            
            if (!file_exists(public_path('img/validation/deposit/'))) {
                mkdir(public_path('img/validation/deposit'), 0777, true);
            }
            
           
            $destinationIMG      = public_path('img/validation/deposit/');
            $upload_bukti_success  =  $bukti->move($destinationIMG, $nameBukti);
            
                
            $deposit = Deposit::where('user_id', Auth::user()->id)->findOrFail($request->id);
            
            if( $deposit->status == 0 )
            {
                $deposit->status = 3;// status proses
                $deposit->note = 'Pembayaran telah di konfirmasi, proses validasi.';
                $deposit->bukti = $nameBukti;
                $deposit->save();
                
                return redirect()->back();
            }
        // }catch(\Exception $e){
        //     \Log::error($e);
        //     return redirect()->back()->with('alert-error','Terjadi Kesalahan');
        // }
       
    }
    
    public function transferSaldo()
    {
        $URL_uri = request()->segment(1).'/'.request()->segment(2);
        $datasubmenu2 = MenuSubmenu::getSubMenuOneMemberURL($URL_uri)->first();

        if($datasubmenu2->status_sub != 0 )
        {
            return view('member.deposit.transfer-saldo.index');
        }
        else
        {
            abort(404);
        }
    }
    
    public function cekNomor(Request $request)
    {
        $rules = array (
            'no_tujuan' => 'required',
        );
        
        $validator = Validator::make ($request->all(), $rules );
        
        if ($validator->fails ())
        {
            return Response::json ( array (
                    'errors' => $validator->getMessageBag ()->toArray () 
            ) );
        }
        else
        {
            $user = User::where('phone', $request->no_tujuan)->first();
            return Response::json($user);
        }
    }
    
    public function kirimSaldo(Request $request)
    {
        if( $this->settings->status == 0 ) {
            return redirect()->back()->with('alert-error', 'Sistem Sedang Maintenance, mohon kesabarannya menunggu.');
        }
        
        $this->validate($request, [
            'no_tujuan' => 'required',
            'nominal' => 'required',
            'password' => 'required|passcheck:' . Auth::user()->password,
        ],[
            'no_tujuan.required' => 'Nomor Handphone Tujuan Transfer tidak boleh kosong.',
            'nominal.required' => 'Nominal Transfer tidak boleh kosong.',
            'password.required' => 'Kata Sandi tidak boleh kosong.',
            'password.passcheck' => 'Kata Sandi tidak cocok, periksa kembali kata sandi anda.',
        ]);
        
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
        
        $nominal = intVal(str_replace(".", "", $request->nominal));
        
        if( $request->no_tujuan != Auth::user()->phone )
        {
            $penerima = User::where('phone', $request->no_tujuan)->first();
            
            if( !empty($penerima) )
            {
                $saldo = Auth::user()->saldo;
                
                if($saldo >= 50000)
                {
                    if( $nominal >= 20000 )
                    {
                        // Kurang Saldo Pengirim
                        $pengirim = Auth::user();
                        $sisaSaldoPengirim = $pengirim->saldo - $nominal;
                        $pengirim->saldo = $sisaSaldoPengirim;
                        $pengirim->save();
                        
                        // Tambah Saldo Penerima
                        $sisaSaldoPenerima = $penerima->saldo + $nominal;
                        $penerima->saldo = $sisaSaldoPenerima;
                        $penerima->save();
                        
                        // Mutasi Saldo Pengirim
                        $mutasiPengirim = new Mutasi();
                        $mutasiPengirim->user_id = $pengirim->id;
                        $mutasiPengirim->type = 'debit';
                        $mutasiPengirim->nominal = $nominal;
                        $mutasiPengirim->saldo  = $sisaSaldoPengirim;
                        $mutasiPengirim->note  = 'TRANSFER SALDO KE '.$request->no_tujuan.' BERHASIL';
                        $mutasiPengirim->save();
                        
                        // Mutasi Saldo Penerima
                        $mutasiPenerima = new Mutasi();
                        $mutasiPenerima->user_id = $penerima->id;
                        $mutasiPenerima->type = 'credit';
                        $mutasiPenerima->nominal = $nominal;
                        $mutasiPenerima->saldo  = $sisaSaldoPenerima;
                        $mutasiPenerima->note  = 'SALDO TRANSFER DARI '.$pengirim->phone;
                        $mutasiPenerima->save();
                        
                        return redirect()->back()->with('alert-success', 'Transfer Saldo Berhasil, Saldo penerima telah di tambahkan.');
                    }
                    else
                    {
                        return redirect()->back()->with('alert-error', 'Transfer Saldo Gagal, minimal nominal saldo yang anda dapat transfer adalah Rp 20.000.');
                    }
                }
                else
                {
                    return redirect()->back()->with('alert-error', 'Transfer Saldo Gagal, anda harus memiliki minimal saldo Rp 50.000 untuk dapat melakukan transfer saldo.');
                }
            }
            else
            {
                return redirect()->back()->with('alert-error', 'Nomor Handphone tujuan transfer tidak ditemukan, periksa kembali nomor handphone tujuan anda.');
            }
        }
        else
        {
            return redirect()->back()->with('alert-error', 'Anda tidak dapat melakukan transfer saldo ke akun anda sendiri.');
        }
    }
    
    public function mutasiSaldo()
    {
        $URL_uri = request()->segment(1).'/'.request()->segment(2);
        $datasubmenu2 = MenuSubmenu::getSubMenuOneMemberURL($URL_uri)->first();

        if($datasubmenu2->status_sub != 0 )
        {
            $mutasiWeb = Mutasi::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
            $mutasiMobile = Mutasi::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
    	    return view('member.deposit.mutasi-saldo.index', compact('mutasiWeb', 'mutasiMobile'));
        }
        else
        {
            abort(404);
        }

    }    

    public function mutasiSaldoDatatables(Request $request)
    {
        $columns = array( 
                            0 =>'no', 
                            1 =>'created_at',
                            2=> 'type',
                            3=> 'nominal',
                            4=> 'saldo',
                            5=> 'trxid',
                            6=> 'note',
                        );
  
        $totalData = Mutasi::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {            
            $posts = Mutasi::where('user_id', Auth::user()->id)
                             ->offset($start)
                             ->limit($limit)
                             ->orderBy('created_at', 'DESC')
                             ->get();
        }
        else
        {
            $search = $request->input('search.value'); 

            if(strtoupper($search) == 'DEBET'){
                $type = 'debit';
            }elseif(strtoupper($search) == 'KREDIT'){
                $type = 'credit';
            }else{
                $type = null;
            };
                  
            $posts =  Mutasi::where('user_id', Auth::user()->id)
                        ->where(function($q) use ($search,$type){
                                $q->where('trxid','LIKE',"%{$search}%");
                                $q->orWhere('note','LIKE',"%{$search}%");
                                if($type != null){
                                    $q->orWhere('type', $type);
                                }
                          })
                        ->offset($start)
                        ->limit($limit)
                        // ->orderBy($order,$dir)
                        ->orderBy('created_at', 'DESC')
                        ->get();

             $totalFiltered = Mutasi::where('user_id', Auth::user()->id)
                                ->where(function($q) use ($search,$type){
                                        $q->where('trxid','LIKE',"%{$search}%");
                                        $q->orWhere('note','LIKE',"%{$search}%");
                                        if($type != null){
                                            $q->orWhere('type', $type);
                                        }
                                  })
                                ->orderBy('created_at', 'DESC')
                                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $no = 0;
            foreach ($posts as $post)
            {
                $no++;
                $nestedData['no']            = $start+$no;
                $nestedData['created_at']    = Carbon::parse($post->created_at)->format('d M Y H:i:s');
                if($post->type == 'debit'){
                    $nestedData['type'] = '<td><label class="label label-danger">debet</label></td>';
                }else{
                    $nestedData['type'] = '<td><label class="label label-success">kredit</label></td>';
                };
                $nestedData['nominal']       = '<td>Rp. '.number_format($post->nominal, 0, '.', '.').'</td>';
                $nestedData['saldo']         = '<td>Rp. '.number_format($post->saldo, 0, '.', '.').'</td>';
                $nestedData['trxid']         = $post->trxid != null?$post->trxid:'-';
                $nestedData['note']          = $post->note;

                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        return json_encode($json_data);
    }
    
    public function redeemVoucher()
    {
        $URL_uri = request()->segment(1).'/'.request()->segment(2);
        $datasubmenu2 = MenuSubmenu::getSubMenuOneMemberURL($URL_uri)->first();

        if($datasubmenu2->status_sub != 0 )
        {
            return view('member.deposit.redeem-voucher.index');
        }
        else
        {
            abort(404);
        }
    }

    public function coinpayments(Request $request, $id)
    {
        $deposit = Deposit::where(['user_id' => Auth::user()->id, 'status' => '0'])->findOrFail($id);
        if( !is_null($deposit) )
        {
            $kurs_IDR_USD = Kurs::getInfo("idr_usd")->value;
            $amount = number_format(($deposit->nominal_trf/$kurs_IDR_USD), 2, ".", "");
            $merchant =CoinPaymentsModel::getMerchantId();
            dd($merchant);
            if( is_numeric($amount) )
            {
                $formData = array(
                        "cmd"           => "_pay",
                        "reset"         => 1,
                        "merchant"      => CoinPaymentsModel::getMerchantId(),
                        "currency"      => "USD",
                        "item_number"   => $deposit->nominal_trf,
                        "item_name"     => "Deposit FirstPay.co.id IDR ".number_format($deposit->nominal_trf, 0, "", ".")." ".Auth::user()->name,
                        "invoice"       => $id,
                        "custom"        => Auth::user()->id,
                        "quantity"      => 1,
                        "max_quantity"  => 1,
                        "want_shipping" => 0,
                        "ipn_url"       => url('/payments/coinpayments/deposit/ipn'),
                        "success_url"   => url('/member/deposit'),
                        "cancel_url"    => url('/member/deposit'),
                        "amountf"       => $amount
                        );

                return view('member.deposit.coinpayments', compact('formData'));
            }
            else {
                return redirect()->back()->with('alert-error', 'Terjadi kesalahan sistem.');
            }
        }
        else {
            return redirect()->back();
        }
    }

    public function coinpaymentsIPN(Request $request)
    {
        $fetch = CoinPaymentsModel::fetchIPN();

        if( $fetch !== false )
        {
            if( ($fetch['currency1'] == "USD") && ($fetch['received_amount'] >= $fetch['amount2']) && ($fetch['status'] == 2 || $fetch['status'] >= 100) )
            {
                $userid = @intval($fetch['custom']);
                $depositId = @intval($fetch['invoice']);

                if( $userid > 0 && $depositId > 0 )
                {
                    $kurs_IDR_USD = Kurs::getInfo("idr_usd")->value;

                    $amount_idr = @number_format($fetch['item_number'], 0, "", "");
                    $received_usd = @number_format($fetch['amount1'], 2, ".", "");
                    $received_idr = @number_format(($received_usd*$kurs_IDR_USD), 0, "", "");

                    $deposit = Deposit::where(['user_id' => $userid, 'nominal_trf' => $amount_idr])->whereIn('status', [0, 3])->findOrFail($depositId);
                    $user = User::findOrFail($userid);
                    if( !is_null($deposit) && !is_null($user) )
                    {
                        if( $received_idr >= ($deposit->nominal_trf-500) )
                        {
                            $saldo = $user->saldo + $deposit->nominal_trf;
                            $user->saldo = $saldo;
                            $user->save();

                            $deposit->status = 1;// status sukses
                            $deposit->expire = 0;
                            $deposit->note = 'Deposit sebesar Rp '.number_format($deposit->nominal_trf, 0, '.', '.').' berhasil ditambahkan, saldo sekarang Rp '.number_format($saldo, 0, '.', '.').'.';
                            $deposit->save();

                            $mutasi          = new Mutasi();
                            $mutasi->user_id = $user->id;
                            $mutasi->trxid = $deposit->id;
                            $mutasi->type    = 'credit';
                            $mutasi->nominal = $deposit->nominal_trf;
                            $mutasi->saldo   = $saldo;
                            $mutasi->note    = 'DEPOSIT/TOP-UP SALDO via Coinpayments';
                            $mutasi->save();

                            SMSGateway::send($user->phone, 'Yth. '.$user->name.', deposit Rp '.number_format($deposit->nominal_trf, 0, '.', '.').' SUKSES via '.$deposit->bank->nama_bank.'. Saldo akhir: Rp '.number_format($saldo, 0, '.', '.').' ~ '.$this->setting->nama_sistem);
                        }
                    }
                }
            }
        }
    }

    public function kurs(Request $request, $amount)
    {
        dd( Kurs::getInfo('usd_idr')->value );
    }

    public function paypalPayment(Request $request)
    {
        $setting = Setting::first();
        $user = User::findOrFail(Auth::user()->id);
        $bank_kategori_id = $request->id_category_bank;
        $bankCategory = Bank_kategori::findOrFail($bank_kategori_id);
        $bank = Bank::where('bank_kategori_id', $bankCategory->id)->findOrFail($request->bank_id);
        $nominal = (int) str_replace(".", "", $request->nominal);
        $amt = (int) str_replace(".", "", $request->nominal) + intval($setting->deposit_fee);
        $kurs = Kurs::where('name', 'paypal_idr')->first()->value;
        $usd = ($amt/$kurs);
        $usd = number_format($usd, 2, '.', '');
        
        DB::beginTransaction();
        
        try
        {
            $check = PayPalModel::where('user_id', $user->id)
                                ->where('amount_idr', $amt)
                                ->whereIn('status', [0, 1])
                                ->where('expired_at', '>', Carbon::now()->format('Y-m-d H:i:s'))
                                ->first();
                              
            if( $check ) {
                return redirect()->route('payments.paypal.view', ['id' => $check->id]);
            }
            
            $deposit                    = new Deposit();
            $deposit->bank_id           = $bank->id;
            $deposit->bank_kategori_id  = $bankCategory->id;
            $deposit->code_unik         = NULL;
            $deposit->nominal           = $nominal;
            $deposit->nominal_trf       = $amt;
            $deposit->note              = 'Menunggu pembayaran sebesar $'.number_format($usd, 2, '.', '').' USD (setara: Rp '.number_format($amt, 0, '', '.').') ke '.$bank->no_rek;
            $deposit->user_id           = $user->id;
            $deposit->save();
            
            $pp = PayPalModel::create([
                'action'        => 'deposit',
                'deposit_id'    => $deposit->id,
                'user_id'       => $user->id,
                'amount_idr'    => $amt,
                'amount_usd'    => $usd,
                'kurs'          => $kurs,
                'paypal_email'  => $bank->no_rek,
                'paypal_name'   => $bank->atas_nama,
                'paypal_username' => $bank->code,
                'note'          => 'TOPUP '.strtoupper($setting->nama_sistem).' INV'.$deposit->id,
                'checking_time' => Carbon::now()->format('Y-m-d H:i:s'),
                'expired_at'    => Carbon::now()->addHours(24)->format('Y-m-d H:i:s')
                ]);
            $deposit->save();
            $deposit->payment_url = url('member/view/'.$pp->id);
            
            DB::commit();
            
            return redirect()->route('payments.paypal.view', ['id' => $pp->id]);
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            
            if( $e instanceof \Illuminate\Database\QueryException ) {
                // 
            }
            'Transaksi tidak dapat diproses ['.__LINE__.']';
           // return redirect()->back()->with('alert-error',$e->getMessage());
        }
    }

    function data($nominal,$paymentMethod,$username,$Useremail,$Userphone,$merchantCode,$merchantRef,$privateKey,$expiredTime){
     
        $item = [
            "name" =>"Topup Saldo ".number_format($nominal, 0, '', '.'),
            "price"=>$nominal,
            "quantity"=>1,
        ];
        $itemDetails = [$item];
        $amount = $nominal;
        
        $signature = hash_hmac('sha256',$merchantCode.$merchantRef.$amount,$privateKey);
        $data = [
            'method'=>$paymentMethod,
            'merchant_ref'=>"$merchantRef",
            'amount'=>$amount,
            'customer_name'=>$username,
            'customer_email'=>$Useremail,
            'customer_phone'=>$Userphone,
            'order_items'=>$itemDetails,
            'return_url'=>url('member/deposit'),
            'expired_time'=>$expiredTime,
            'signature'=>$signature,
        ];
        return $data;
    }

    function paymenttripay($deposit,$apikey,$data){
        $params = json_encode($data);   
        $curl = curl_init();
    
        curl_setopt($curl,CURLOPT_FRESH_CONNECT,true);
        curl_setopt($curl,CURLOPT_URL,"https://payment.tripay.co.id/api/transaction/create");
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_FAILONERROR,false);
        curl_setopt($curl,CURLOPT_POST,true);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$params);
        curl_setopt($curl,CURLOPT_HTTPHEADER,array(
        'Content-Type: application/json',
        "Authorization: Bearer ".$apikey,
        ));
    
        $request = curl_exec($curl);
      
        $err = curl_error($curl);
      
        $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        if($httpCode == 200)
        {
            $result = json_decode($request,true);
            if($result['success'] !== false)
            {   
                 $deposit->nominal_trf = $result['data']['amount'];
                $deposit->payment_url = $result['data']['checkout_url'];
                $deposit->save();
                DB::commit();
                return redirect($result['data']['checkout_url']);
            }
        }else{
           DB::rollback();
           return redirect()->back()->with('alert-error', "Transaksi tidak dapat diproses ");
        }
    }
}