<?php

namespace App\Http\Controllers\Member;

use DB, Auth, Response, Validator,DigiFlazz,Log;
use App\AppModel\Pembayarankategori;
use App\AppModel\Pembayaranoperator;
use App\AppModel\Pembayaranproduk;
use App\AppModel\Antriantrx;
use App\AppModel\BlockPhone;
use App\AppModel\Transaksi;
use App\AppModel\Temptransaksi;
use App\AppModel\Mutasi;
use App\AppModel\Tagihan;
use App\AppModel\Setting;
use App\AppModel\SMSGateway;
use App\AppModel\Komisiref;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Exception;
use Pulsa;
class PembayaranController extends Controller
{
    //role user
    public $personal_role   = 1;
    public $admin_role      = 2;
    public $agen_role       = 3;
    public $enterprise_role = 4;
    
    public function __construct()
    {
        $this->settings = Setting::first();
    }
    
    public function formBayar(Request $request, $slug)
    {
        $kategori   = Pembayarankategori::where('slug', $slug)->firstOrFail();
        $operator   = Pembayaranoperator::where('pembayarankategori_id', $kategori->id)->firstOrFail();
        $produk     = Pembayaranproduk::where('pembayarankategori_id', $kategori->id)->where('pembayaranoperator_id', $operator->id)->get();
        $antrian    = Antriantrx::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->Paginate(50);
        $transaksi  = Transaksi::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(3);
        if($kategori->status == 1)
        {
        	return view('member.pembayaran.form', compact('kategori', 'operator', 'antrian', 'transaksi','produk'));
        }
        else
        {
        	return redirect()->back()->with('alert-error', 'Halaman tidak dapat diakses, produk ini masih dalam pengembangan.');
        }
    }

    public function getTypeheadTagihan(Request $request)
    {
        $data        = $request->q;
        $suggestions = Tagihan::select('no_pelanggan')->where('user_id', Auth::user()->id)->where('no_pelanggan', 'LIKE',"%{$data}%")->orderBy('created_at', 'DESC')->limit(10)->get();
        
        $output = array();
        foreach ($suggestions as $key ) {
            $output[] =  $key->no_pelanggan;
        }
        return json_encode($output);
    }
    
    public function findproductpembayaran(Request $request)
    {
        $produk = Pembayaranproduk::where('pembayarankategori_id', $request->pembayarankategori_id)->where('pembayaranoperator_id', $request->pembayaranoperator_id)->get();
        return Response::json($produk);
    }

    public function cektagihan(Request $request)
    {
        $produk = $request->input('produk');
       
        if($this->settings->status == 0 and $this->settings->status_server == 0) {
            return redirect()->back()->with('alert-error', 'Sistem Sedang Maintenance, mohon kesabarannya menunggu.');
        }
        
        if( $this->settings->force_verification == 1 )
        {
            $verification = DB::table('users_validations')
                        ->select('*')
                        ->where('user_id', Auth::id())
                        ->first();
        
            if( !$verification )
            {
                return redirect()->back()->with('alert-error', 'Untuk melakukan transaksi, akun Anda harus terverifikasi, silahkan lakukan verifikasi <a href="/member/validasi-users" style="font-weight:bold;text-decoration:underline;">DISINI</a> .');
            }
            elseif( $verification->status != '1' )
            {
                return redirect()->back()->with('alert-error', 'Mohon maaf, verifikasi akun Anda masih dalam proses review. Anda belum dapat melakukan transaksi ini');
            }
        }
        
        $this->validate($request,[
            'produk'         => 'required',
            'nomor_rekening' => 'required',
            'target'         => 'required',
            'pin'            => 'required',
        ],[
            'produk.required'         => 'Produk tidak boleh kosong',
            'nomor_rekening.required' => 'Nomor Pelanggan tidak boleh kosong',
            'target.required'         => 'Nomor HP Pembeli tidak boleh kosong',
            'pin.required'            => 'PIN tidak boleh kosong',
        ]);

        $produk       = $request->produk;
        $no_pelanggan = $request->nomor_rekening;
        $phone        = $request->target;
        $pin          = $request->pin;

        $userCek      = User::where('id', Auth::user()->id)->first();
        $cekTarget    = BlockPhone::where('phone', $phone)->first();
        $cekPhoneUser = BlockPhone::where('phone', $userCek->phone)->first();
        
        if( !is_null($cekTarget) || !is_null($cekPhoneUser) )
        {
            return redirect()->back()->with('alert-error', 'No.Target termasuk nomor yang tercatat dalam daftar Blacklist Kami.');
        }
        elseif($userCek->status == 0)
        {
            return redirect()->back()->with('alert-error', 'Maaf, Akun anda di nonaktifkan!');
        }
        elseif( $userCek->pin != $request->pin )
        {
            return redirect()->back()->with('alert-error', 'Maaf, Pin anda salah!');
        }
        if($userCek->status_saldo == 0){
            return redirect()->back()->with('alert-error','Maaf saldo anda dikunci oleh admin dan tidak bisa digunakan');
        }
        
        DB::beginTransaction();
        
        try
        {
            $getPembayaranData = Pembayaranproduk::with('pembayarankategori')->where('code', $produk)->first();
            
            $cektagihanLokal = Tagihan::where(['no_pelanggan'=>$no_pelanggan,'code'=>$getPembayaranData->code,'product_name'=>$getPembayaranData->product_name])->where('status',0)->first();
            
            if($cektagihanLokal){
                return redirect()->back()->with('alert-error','Anda sudah melakukan pengecekan tagihan dengan No.pelanggan '.$no_pelanggan.' ('.ucwords($cektagihanLokal->nama).') ');
            }

            if( !$getPembayaranData ) {
                return redirect()->back()->with('alert-error', 'Maaf, produk sedang gangguan');
            }
         
            $tagihan = Tagihan::create([
                    'apiserver_id'  => $getPembayaranData->apiserver_id,
                    'code'          => $getPembayaranData->code,
                    'user_id'       => $userCek->id,
                    'phone'         => $phone,
                    'no_pelanggan'  => $no_pelanggan,
                    'via'           => 'DIRECT',
                    'product_name'   => $getPembayaranData->product_name,
                ]);
            
            $cekTagihan = Pulsa::cek_tagihan($request->produk,$request->target,$request->nomor_rekening);
            
            $cekSaldo = Pulsa::cek_saldo();
          
            $kategori = strtoupper($getPembayaranData->pembayarankategori->product_name);
            
            if( $cekTagihan->success == true )
            {
                $cekTagihan = $cekTagihan->data;
                
                if($cekSaldo->data >= $cekTagihan->jumlah_bayar)
                { 
                    $tagihan->update([
                       'tagihan_id'     => $cekTagihan->tagihan_id,
                       'no_pelanggan'   => $cekTagihan->no_pelanggan,
                       'nama'           => ucwords($cekTagihan->nama),
                       'periode'        => $cekTagihan->periode,
                       'jumlah_tagihan' => $cekTagihan->jumlah_bayar,
                       'admin'          => $getPembayaranData->price_markup + upline_markup(),
                       'jumlah_bayar'   => ($cekTagihan->jumlah_bayar + $getPembayaranData->price_markup + upline_markup()),
                    ]);   
                }
                else
                {
                    return redirect()->back()->with('alert-error','Sistem Pembayaran Error, mohon laporkan admin supaya bisa segera ditangani.Terima kasih');
                }
            }
            else
            {
                return redirect()->back()->with('alert-error', 'Cek Pembayaran gagal, silahkan coba kembali');
            }
            
            DB::commit();
            
            $request->session()->regenerateToken();
            
            return redirect()->to('/member/tagihan-pembayaran/'.$tagihan->id);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            Log::error($e);
            if( $e->getCode() == '1' ) {
                return redirect()->back()->with('alert-error', $e->getMessage());
            }
            
            return redirect()->back()->with('alert-error', 'Cek pembayaran gagal, silahkan coba kembali [err-back]');
        }
    }
    
    public function cektagihanhome(Request $request)
    {
        $produk = $request->input('produk');
       
        if($this->settings->status == 0 && $this->settings->status_server == 0){
            return Response::json([ 'success' => false, 'message' => 'Sistem Sedang Maintenance, mohon kesabarannya menunggu.']);
        }
        
        if( $this->settings->force_verification == 1 )
        {
            $verification = DB::table('users_validations')
                        ->select('*')
                        ->where('user_id', Auth::id())
                        ->first();
        
            if( !$verification )
            {
                return Response::json([ 'success' => false, 'message' => 'Untuk melakukan transaksi ini, akun Anda harus terverifikasi, silahkan lakukan verifikasi di menu Validasi User']);
            }
            elseif( $verification->status != '1' )
            {
                return Response::json([ 'success' => false, 'message' => 'Mohon maaf, verifikasi akun Anda masih dalam proses review. Anda belum dapat melakukan transaksi ini']);
            }
        }
        
        $this->validate($request,[
            'produk'         => 'required',
            'nomor_rekening' => 'required',
            'target'         => 'required',
            'pin'            => 'required',
        ],[
            'produk.required'         => 'Produk tidak boleh kosong',
            'nomor_rekening.required' => 'Nomor Pelanggan tidak boleh kosong',
            'target.required'         => 'Nomor HP Pembeli tidak boleh kosong',
            'pin.required'            => 'PIN tidak boleh kosong',
        ]);

        $produk       = $request->produk;
        $no_pelanggan = $request->nomor_rekening;
        $phone        = $request->target;
        $pin          = $request->pin;

        $userCek      = User::where('id',Auth::user()->id)->first();
        $cekTarget    = BlockPhone::where('phone', $phone)->first();
        $cekPhoneUser = BlockPhone::where('phone',$userCek->phone)->first();
        if( !is_null($cekTarget) || !is_null($cekPhoneUser) ) {
            return Response::json([ 'success' => false, 'message' => 'No.Target termasuk nomor yang tercatat dalam daftar Blacklist Kami.']);
        }

        if($userCek->status == 0)
        {
            return Response::json([ 'success' => false, 'message' => 'Maaf, Akun anda di nonaktifkan!']);
        }
        
        if($userCek->status_saldo == 0){
            return Response::json(['success'=>false,'message'=>'Maaf, saldo anda dikunci oleh admin dan tidak bisa digunakan']);
        }
        if( $userCek->pin != $request->pin )
        {
            return Response::json([ 'success' => false, 'message' => 'Maaf, Pin anda salah!']);
        }

        DB::beginTransaction();
        
        try
        {
            $getPembayaranData = Pembayaranproduk::with('pembayarankategori')->where('code', $produk)->first();
            
            if( !$getPembayaranData ) {
                return Response::json([ 'success' => false, 'message' => 'Maaf, produk sedang gangguan']);
            }
            
            $tagihan = Tagihan::create([
                    'apiserver_id'   => $getPembayaranData->apiserver_id,
                    'user_id'       =>$userCek->id,
                    'phone'         =>$phone,
                    'no_pelanggan'  =>$no_pelanggan,
                    'via'           =>'DIRECT',
                    'product_name'   => $getPembayaranData->product_name,
                ]);
            
            $cekTagihan = Pulsa::cek_tagihan($request->produk,$request->target,$request->nomor_rekening);
       
            $cekSaldo = Pulsa::cek_saldo();
         
            $kategori = strtoupper($getPembayaranData->pembayarankategori->product_name);
            
            if($cekTagihan->success == true)
            {
                $cekTagihan = $cekTagihan->data;
                if($cekSaldo->data >= $cekTagihan->jumlah_bayar){
                    
                    $tagihan->update([
                       'tagihan_id'     => $cekTagihan->tagihan_id,
                       'no_pelanggan'   => $cekTagihan->no_pelanggan,
                       'nama'           => ucwords($cekTagihan->nama),
                       'periode'        => $cekTagihan->periode,
                       'jumlah_tagihan' => $cekTagihan->jumlah_bayar + upline_markup(),
                       'admin'          => $getPembayaranData->price_markup ,
                       'jumlah_bayar'   => ($cekTagihan->jumlah_bayar + $getPembayaranData->price_markup + upline_markup()),
                    ]);
                }else{
                  return Response::json(['success'=>false, 'message'=>'Sistem Pembayaran Erorr, mohon laporkan admin supaya bisa segera ditangani.Terima kasih']);
                }
            }else{
                return Response::json(['success'=>false, 'message'=>'Sistem Pembayaran Erorr, mohon laporkan admin supaya bisa segera ditangani.Terima kasih']);
            }
            
            DB::commit();
            
            $tagihan->token = csrf_token();
            return Response::json($tagihan);
            
        }
        catch (\Exception $e)
        {
            DB::rollback();
            Log::error($e);
            return Response::json([ 'success' => false, 'message' => 'Cek pembayaran gagal, silahkan coba kembali.[err-back]']);
        }
    }
    
    public function bayartagihan(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'order_id'          => 'required',
        ]);
        
        if( $validate->fails() ) {
            return redirect()->back()->with('alert-error', 'Maaf terjadi kesalahan.');
        }

        if($this->settings->status == 0 && $this->settings->status_server == 0) {
            return redirect()->back()->with('alert-error', 'Sistem Sedang Maintenance, mohon kesabarannya menunggu.');
        }
        
        if( $this->settings->force_verification == 1 )
        {
            $verification = DB::table('users_validations')
                        ->select('*')
                        ->where('user_id', Auth::id())
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
        
        $user = Auth::user();

        $tagihan = Tagihan::where('id', $request->order_id)->where('user_id', $user->id)->first();

        #jika tagihan ini bukan milik user
        if( !$tagihan ) {
            $message = 'Maaf ID Tagihan ini bukan milik Anda.';
            return redirect()->back()->with('alert-error', 'Maaf ID Tagihan ini bukan milik Anda.');
        }
 
        $userCek      = User::where('id', $user->id)->first();
        $cekTarget    = BlockPhone::where('phone', $tagihan->no_pelanggan)->first();
        $cekPhoneUser = BlockPhone::where('phone', $userCek->phone)->first();
        
        if($userCek->status == 0){
            return redirect()->back()->with('alert-error','Maaf akun anda dinonaktifkan');
        }
        if($userCek->status_saldo == 0){
            return redirect()->back()->with('alert-error','Maaf saldo anda dikunci oleh admin dan tidak bisa digunakan');
        }
        if( !is_null($cekTarget) || !is_null($cekPhoneUser) ) {
            return redirect()->back()->with('alert-error', 'No.Target termasuk nomor yang tercatat dalam daftar Blacklist Kami.');
        }

        if( $userCek->saldo <= $tagihan->jumlah_bayar ) { // jika saldo member tidak cukup
            return redirect()->back()->with('alert-error', 'Saldo Anda tidak mencukupi untuk melakukan transaksi ini, TOPUP saldo anda untuk dapat melakukan transaksi');
        }

        DB::beginTransaction();
          
        try
        {
            $sisaSaldo = $userCek->saldo - $tagihan->jumlah_bayar;
            $userCek->saldo = $sisaSaldo;
            $userCek->save();
            
            $bayarSukses                   = new Transaksi();
            $bayarSukses->apiserver_id     = $tagihan->apiserver_id;                
            $bayarSukses->order_id         = 0;
            $bayarSukses->tagihan_id       = $tagihan->tagihan_id;
            $bayarSukses->code             = "";
            $bayarSukses->produk           = "";
            $bayarSukses->harga_default    =  $tagihan->jumlah_tagihan;
            $bayarSukses->harga_markup     =  $tagihan->admin;
            $bayarSukses->total            =  $tagihan->jumlah_bayar;
            $bayarSukses->target           = "";
            $bayarSukses->mtrpln           = "";
            $bayarSukses->note             = "Initialize";
            $bayarSukses->pengirim         = $request->ip();
            $bayarSukses->status           = 0; // status proses
            $bayarSukses->user_id          = $userCek->id;
            $bayarSukses->via              = 'DIRECT';
            $bayarSukses->jenis_transaksi  = 'otomatis';
            $bayarSukses->saldo_before_trx = $userCek->saldo + $tagihan->jumlah_bayar;
            $bayarSukses->saldo_after_trx  = $userCek->saldo;
            $bayarSukses->save();
            
            $tagihan->status = 1; // status proses
            $tagihan->expired = 1;
            $tagihan->save();
            
            $mutasi          = new Mutasi();
            $mutasi->trxid   = $bayarSukses->id;
            $mutasi->user_id = $userCek->id;
            $mutasi->type    = 'debit';
            $mutasi->nominal = $tagihan->jumlah_bayar;
            $mutasi->saldo   = $userCek->saldo;
            $mutasi->note    = 'PEMBAYARAN TAGIHAN '.$tagihan->product_name.' '.$tagihan->no_pelanggan;
            $mutasi->save();
            
            $tagihan_id   = $tagihan->id;
            $transaksi_id = $bayarSukses->id;
            $mutasi_id    = $mutasi->id;
            $loop = true;
            //PROSES BONUS REFERRAL
            if( $userCek->referred_by != NULL )
            {
                $user_ref    = User::where('id',$userCek->referred_by)->first();
                                       
                do {
                    if($user_ref->referred_by == null){
                        $loop = false;
                    }else{
                        $bonus_saldo = intval($user_ref->saldo) + intval($user_ref->referral_markup);

                        $user_ref->update([
                            'saldo'=>$bonus_saldo,
                        ]);

                        DB::table('mutasis_komisi')
                            ->insert([
                                'user_id'=>$user_ref->id,
                                'from_reff_id'=>$user->id,
                                'komisi'=>$user_ref->referral_markup,
                                'jenis_komisi'=>2,
                                'note'=>'Trx '.$data->code,
                                'created_at'=>date('Y-m-d H:i:s'),
                                'updated_at'=>date('Y-m-d H:i:s'),
                            ]);

                        $mutasi_bonus = new Mutasi();
                        $mutasi_bonus->user_id = $user_ref->id;
                        $mutasi_bonus->trxid   = $transaksis->order_id;
                        $mutasi_bonus->type    = 'credit';
                        $mutasi_bonus->nominal = $user_ref->referral_markup;
                        $mutasi_bonus->saldo   = intval($user_ref->saldo) + intval($user_ref->referral_markup);
                        $mutasi_bonus->note    = "BONUS TRANSAKSI REFERRAL (".$user->name.", #".$data->api_trxid.")";
                        $mutasi_bonus->save();
                        
                        $user_ref    = User::where('id',$user_ref->referred_by)->first(); 
                    }
                }
                while($loop);
            }
            
            $product = Pembayaranproduk::where('product_name', $tagihan->product_name)->first();
            
            $bayartagihan = Pulsa::trx_pembayaran($tagihan->tagihan_id);
            
            if( $bayartagihan->success != true ) {
                throw new \Exception($bayartagihan->message, 1);
            }
            
            $bayartagihan = $bayartagihan->data;
        
            $bayarSukses->order_id         = $bayartagihan->order_id;
            $bayarSukses->code             = $bayartagihan->code;
            $bayarSukses->produk           = $bayartagihan->produk;
            $bayarSukses->target           = $tagihan->phone;
            $bayarSukses->mtrpln           = $bayartagihan->mtrpln;
            $bayarSukses->note             = $bayartagihan->note;
            $bayarSukses->save();
        
            DB::commit();
            
            $request->session()->regenerateToken();
            
            return redirect()->to('/member/riwayat-transaksi/'.$bayarSukses->id);    
        }
        catch (\Exception $e)
        {
            Log::error($e);
            DB::rollback();
            
            if( $e->getCode() == '1' ) { // response error dari API
                return redirect()->back()->with('alert-error', $e->getMessage());
            }
            
            return redirect()->back()->with('alert-error', 'Please try again Error.[err-back]');
        }
    }
    
  
}