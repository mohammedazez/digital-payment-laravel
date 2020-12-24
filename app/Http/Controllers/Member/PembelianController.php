<?php

namespace App\Http\Controllers\Member;

use Response, Auth, Validator, Input, Notif, DigiFlazz,Log;
use App\Jobs\QueueTransaksi;
use App\Jobs\QueuePembelian;
use App\User;
use App\AppModel\Antriantrx;
use App\AppModel\Pembeliankategori;
use App\AppModel\Pembelianoperator;
use App\AppModel\Pembelianproduk;
use App\AppModel\V_pembelianproduk_personal as Personal;
use App\AppModel\V_pembelianproduk_agen as Agen;
use App\AppModel\V_pembelianproduk_enterprise as Enterprise;
use App\AppModel\Transaksi;
use App\AppModel\Temptransaksi;
use App\AppModel\Setting;
use App\AppModel\Mutasi;
use App\AppModel\MenuSubmenu;
use App\AppModel\SMSGateway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppModel\BlockPhone;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Uuid;

class PembelianController extends Controller
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

    public function formBeli($title)
    {
        $kategori   = Pembeliankategori::where('slug', $title)->where('status', 1)->firstOrFail();
        $antrian    = Antriantrx::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        $transaksi  = Transaksi::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(3);
        
        $trxForOption = Transaksi::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        $transaksisMobile = $trxForOption;

        if ( count($kategori->pembelianoperator) == 1 )
        {
            $operator = Pembelianoperator::where('id', $kategori->pembelianoperator->first()->id)->first();
            return view('member.pembelian.form', compact('kategori', 'operator', 'antrian', 'transaksi','trxForOption','transaksisMobile'));
        }
        else
        {
            return view('member.pembelian.form', compact('kategori', 'antrian', 'transaksi','trxForOption','transaksisMobile'));
        }
    }    
    
    public function getTypehead(Request $request)
    {
        $data        = $request->q;
        $suggestions = Transaksi::select('target')->where('user_id', Auth::user()->id)->where('target', 'LIKE',"%{$data}%")->orderBy('created_at', 'DESC')->limit(10)->get();
        
        $output = array();
        foreach ($suggestions as $key ) {
            $output[] =  $key->target;
        }
        return json_encode($output);
    }
    
    public function getTypeheadPLN(Request $request)
    {
        $data        = $request->q;
        $suggestions = Transaksi::select('mtrpln')->where('user_id', Auth::user()->id)->whereNotIn('mtrpln', ['-'])->where('mtrpln', 'LIKE',"%{$data}%")->orderBy('created_at', 'DESC')->limit(10)->get();
        
        $output = array();
        foreach ($suggestions as $key ) {
            $output[] =  $key->mtrpln;
        }
        return json_encode($output);
    }

    public function riwayatTransaksiDatatables(Request $request)
    {
        $columns = array( 
                            0 =>'no', 
                            1 =>'id',
                            2 => 'total',
                            3 => 'target',
                            4 => 'mtrpln',
                            5 => 'pengirim',
                            6 => 'via',
                            7 => 'created_at',
                            8 => 'status',
                            9 => 'action',
                        );
  
        $totalData = Transaksi::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {            
            $posts = Transaksi::where('user_id', Auth::user()->id)
                             ->offset($start)
                             ->limit($limit)
                             // ->orderBy($order,$dir)
                             ->orderBy('created_at', 'DESC')
                             ->get();
        }else {
            $search = $request->input('search.value'); 

            if(strtoupper($search) == 'PROSES'){
                $stts = '0';
            }elseif(strtoupper($search) == 'BERHASIL'){
                $stts = '1';
            }elseif(strtoupper($search) == 'GAGAL'){
                $stts = '2';
            }elseif(strtoupper($search) == 'REFUND'){
                $stts = '3';
            }else{
                $stts = null;
            };
                  
            $posts =  Transaksi::select('transaksis.id','transaksis.produk','transaksis.target','transaksis.mtrpln','transaksis.pengirim','transaksis.total','transaksis.created_at','transaksis.updated_at','transaksis.status')
                        ->where('transaksis.user_id', Auth::user()->id)
                        ->where(function($q) use ($search, $stts){
                                $q->where('transaksis.id','LIKE',"%{$search}%");
                                $q->orWhere('transaksis.produk', 'LIKE',"%{$search}%");
                                $q->orWhere('transaksis.target', 'LIKE',"%{$search}%");
                                $q->orWhere('transaksis.mtrpln', 'LIKE',"%{$search}%");
                                $q->orWhere('transaksis.via', 'LIKE',"%{$search}%");
                                if($stts != null){
                                    $q->orWhere('transaksis.status', $stts);
                                }
                          })
                        ->offset($start)
                        ->limit($limit)
                        // ->orderBy($order,$dir)
                        ->orderBy('transaksis.created_at', 'DESC')
                        ->get();

             $totalFiltered = Transaksi::select('transaksis.id','transaksis.produk','transaksis.target','transaksis.mtrpln','transaksis.pengirim','transaksis.total','transaksis.created_at','transaksis.updated_at','transaksis.status')
                                ->where('transaksis.user_id', Auth::user()->id)
                                ->where(function($q) use ($search, $stts){
                                    $q->where('transaksis.id','LIKE',"%{$search}%");
                                    $q->orWhere('transaksis.produk', 'LIKE',"%{$search}%");
                                    $q->orWhere('transaksis.target', 'LIKE',"%{$search}%");
                                    $q->orWhere('transaksis.mtrpln', 'LIKE',"%{$search}%");
                                    $q->orWhere('transaksis.via', 'LIKE',"%{$search}%");
                                    if($stts != null){
                                        $q->orWhere('transaksis.status', $stts);
                                    }
                                  })
                                ->orderBy('transaksis.created_at', 'DESC')
                                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $no = 0;
            foreach ($posts as $post)
            {
                $no++;
                $nestedData['no']         = $start+$no;
                $nestedData['id']         = '#'.$post->id;
                $nestedData['produk']     = (isset($post->produk)?substr($post->produk, 0, 20).(strlen($post->produk) > 20 ? ' ...' : '') : '-');
                $nestedData['total']      = '<td>Rp. '.number_format($post->total, 0, '.', '.').'</td>';
                $nestedData['target']     = $post->target;
                $nestedData['mtrpln']     = $post->mtrpln;
                $nestedData['pengirim']   = $post->pengirim;
                $nestedData['via']        = '<code>'.$post->via.'<code>';
                $nestedData['created_at'] = Carbon::parse($post->created_at)->format('d M Y H:i:s');

                if($post->status == 0){
                    $nestedData['status'] = '<td><span class="label label-warning">PROSES</span></td>';
                }elseif($post->status == 1){
                    $nestedData['status'] = '<td><span class="label label-success">BERHASIL</span></td>';
                }elseif($post->status == 2){
                    $nestedData['status'] = '<td><span class="label label-danger">GAGAL</span></td>';
                }elseif($post->status == 3){
                    $nestedData['status'] = '<td><span class="label label-primary">REFUND</span></td>';
                };
                $nestedData['action'] = '<td><a href="'.url('/member/riwayat-transaksi', $post->id).'" class="btn-loading label label-primary">Detail</a></td>';
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

    public function prefixproduct(Request $request)
    {
        $pembeliankategori_id = $request->parent;
        
        $prefix = $request->prefix;
     
        $prefixBolt = ["998","999"];
        $_s = substr($prefix, 0, 3);
        
        if( in_array($_s, $prefixBolt) )
        {
            $pembelianoperator = Pembelianoperator::where('pembeliankategori_id', $pembeliankategori_id)->where('prefix', 'LIKE', '%'.$_s.'%')->orderBy('product_name', 'ASC')->get();
            $operator = Pembelianoperator::where('pembeliankategori_id', $pembeliankategori_id)->where('prefix', 'LIKE', '%'.$_s.'%')->orderBy('product_name', 'ASC')->first();
        }
        else
        {
            $pembelianoperator = Pembelianoperator::where('pembeliankategori_id', $pembeliankategori_id)->where('prefix', 'LIKE', '%'.$prefix.'%')->orderBy('product_name', 'ASC')->get();
            $operator = Pembelianoperator::where('pembeliankategori_id', $pembeliankategori_id)->where('prefix', 'LIKE', '%'.$prefix.'%')->orderBy('product_name', 'ASC')->first();
        }
        
        if( !$operator ) return Response::json(array('operator' => [], 'produk' => []));

        $pembelianoperator_id = $operator->id;
        
        $produk = $request->no_product == 0 ? $this->produkLevel($pembelianoperator_id) : [];
        //$produk = $this->produkLevel($pembelianoperator_id);
       
        return Response::json(array('operator'=>$pembelianoperator, 'produk' => $produk));
    }

    public function findproduct(Request $request)
    {
        $id = $request->pembelianoperator_id;
        $produk = $this->produkLevel($id);
        return Response::json($produk);
    }

     public function produkLevel($id)
     {
        $roleId = Auth::user()->roles()->first()->id;
        $total_markup = upline_markup();
      
        if($roleId == $this->personal_role || $roleId == $this->admin_role)
        {
            $produk = Personal::select('id', 'product_id', 'product_name', 'desc','price_default','price_markup', DB::raw('price + '.$total_markup.' as price'), 'status')->where('pembelianoperator_id', $id)->orderBy('price_default', 'ASC')->get();
        }
        elseif($roleId == $this->agen_role)
        {
            $produk = Agen::select('id', 'product_id', 'product_name', 'desc','price_default','price_markup', DB::raw('price + '.$total_markup. ' as price'), 'status')->where('pembelianoperator_id', $id)->orderBy('price_default', 'ASC')->get();
        }
        elseif($roleId == $this->enterprise_role)
        {
            $produk = Enterprise::select('id', 'product_id', 'product_name', 'desc','price_default','price_markup', DB::raw('price + '.$total_markup. ' as price'), 'status')->where('pembelianoperator_id', $id)->orderBy('price_default', 'ASC')->get();
        }
        else
        {
            $produk = Pembelianproduk::select('id', 'product_id', 'product_name', 'desc','price_default','price_markup', DB::raw('price + '.$total_markup. ' as price'), 'status')->where('pembelianoperator_id', $id)->orderBy('price_default', 'ASC')->get();
        }
        return $produk;
    }


    public function orderproduct(Request $request)
    {
        sleep(1);
    
        if (!$request->isMethod('post')) {
            return redirect()->back()->with('alert-error', 'Transaksi tidak diproses. silahkan ulangi.[err01].');
        }

        if( (date("G") >= 23) && (intval(date("i")) >= 30) )
        {
            return redirect()->back()->with('alert-error', 'Transaksi tidak diproses. Sedang maintenance harian. Silahkan ulangi setelah pukul 00:00 WIB.');
        }

        if($this->settings->status == 0 || $this->settings->status_server == 0){
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

        $v = Validator::make($request->all(), [
            'produk' => 'required',
            'target' => 'required',
            'pin'    => 'required',
        ],[
            'produk.required' => 'Produk tidak boleh kosong',
            'target.required' => 'Nomor Handphone / Rekening Pengisian tidak boleh kosong',
            'pin.required'    => 'PIN tidak boleh kosong',
        ]);
        
        if( $v->fails() ) {
            return redirect()->back()->with('alert-error', $v->errors()->first());
        }
            
        $userCek        = User::where('id', Auth::user()->id)->first();
        $cekTarget      = BlockPhone::where('phone',trim(isset($request->target) ? $request->target:$request->phone))->first();
        $cekPhoneUser   = BlockPhone::where('phone',trim($userCek->phone))->first();
        
        if($userCek->status == 0) {
          return redirect()->back()->with('alert-error', 'Maaf, Akun anda di nonaktifkan!');
        }
        
        if($userCek->status_saldo == 0){
            return redirect()->back()->with('alert-error','Maaf Saldo Anda dikunci oleh admin dan tidak bisa digunakan');
        }

        if( !is_null($cekTarget) || !is_null($cekPhoneUser) ) {
            return redirect()->back()->with('alert-error', 'No.Target termasuk nomor yang tercatat dalam daftar Blacklist Kami.');
        }

        if( $userCek->pin != $request->pin ){
            return redirect()->back()->with('alert-error', 'Maaf, Pin anda salah!');
        }

        // Deklarasi Variable ====================================
        
        $nameTableTemp   = Uuid::generate(5, strtotime("now"), Uuid::NS_DNS);
        $createTemporary = Schema::create($nameTableTemp, function (Blueprint $table) {
          $table->engine = 'InnoDB';
          $table->increments('id');
          $table->string('apiserver_id')->nullable();
          $table->string('type')->nullable();
          $table->string('produk');
          $table->string('target');
          $table->string('no_meter_pln')->nullable();
          $table->timestamps();
          $table->temporary();
        });

        if (Schema::hasTable($nameTableTemp))
        {
            Schema::drop($nameTableTemp);
            return redirect()->back()->with('alert-error', 'Transaksi Tidak Diproses. Ulangi transaksi[err-temp01].');
        }
        
        #insert ke table temporary. jika paramnya member tidak ada maka memasukkan pararam dari API
        $cekcode = Pembelianproduk::where(['product_id'=>$request->produk])->first();
      
        if(empty($cekcode)){
            return redirect()->back()->with('alert-error','Code Produk tidak ditemukan!');
        }
            
        DB::table($nameTableTemp)
                ->insert([
                  'apiserver_id'    => $cekcode->apiserver_id,
                  'type'            => $request->type,
                  'produk'          => $request->produk,
                  'target'          => $request->target,
                  'no_meter_pln'    => (!isset($request->no_meter_pln) ? NULL : (($request->no_meter_pln != null && $request->no_meter_pln != '') ? $request->no_meter_pln : NULL)),
                ]);

        $check_temp = DB::table($nameTableTemp)
              ->where('id', '1')
              ->first();
       
        $apiserver_id   = $check_temp->apiserver_id;
        $type           = $check_temp->type;
        $product_id     = $check_temp->produk;
        $target         = $check_temp->target;
        $no_meter_pln   = $check_temp->no_meter_pln;
        $drob_temp      = Schema::drop($nameTableTemp);
        $produk         = produkMembershipAuth($product_id);
      
        if( !$produk ) {
            return redirect()->back()->with('alert-error', 'Produk tidak ditemukan!');
        }
        
         if($produk->status !=1){
            return redirect()->back()->with('alert-error','Produk sedang gangguan');
        }

        $user           = Auth::user();
        
        $ip_address     = $request->ip();
        
        $transaksi      = Transaksi::where('code', $product_id)->where('target', $target)->whereIn('status', [0, 1])->whereDate('created_at', '=', date('Y-m-d'))->first();
        $queue          = Antriantrx::where('code', $product_id)->where('target', $target)->where('status', 0)->whereDate('created_at', '=', date('Y-m-d'))->first();
        
        $currentBalance = $user->saldo;
        $currentBalance = is_numeric($currentBalance) ? $currentBalance : 0;

        if( $currentBalance < $produk->price )
        {
            return redirect()->back()->with('alert-error', 'Transaksi Tidak Diproses. Saldo tidak cukup untuk transaksi ini, silahkan isi saldo anda terlebih dahulu.');
        }
        elseif( !empty($queue) )
        {
            return redirect()->back()->with('alert-error', 'Transaksi '.$produk->product_name.' '.$target.' sudah pernah dilakukan pada '.strftime("%d %b %Y %H:%M", strtotime($queue->created_at)).' status DALAM ANTRIAN');
        }
        elseif( !empty($transaksi) )
        {
            return redirect()->back()->with('alert-error', 'Transaksi '.$produk->product_name.' '.$target.' sudah pernah dilakukan pada '.strftime("%d %b %Y %H:%M", strtotime($transaksi->created_at)).'. Mohon gunakan nominal atau nomor tujuan yang berbeda');
        }
        else
        {
            // get last trx
            $ltx = Antriantrx::where('code', $product_id)->where('target', $target)->where('created_at', '>=', Carbon::now()->subMinutes(5)->toDateTimeString())->count();
            if( $ltx > 0 ) {
                return redirect()->back()->with('alert-error', 'Mohon tunggu 5 menit sebelum mengulai transaksi yang sama atau cek riwayat transaksi Anda');
            }
            
            DB::beginTransaction();
            
            try
            {
                $user = User::find($user->id);
               
                if( !$user ) {
                    throw new \Exception("Gagal");
                }
                
                if( $user->saldo < intval($produk->price) ) {
                    throw new \Exception("Transaksi Tidak Diproses. Saldo tidak cukup untuk transaksi ini, silahkan isi saldo anda terlebih dahulu.");
                }
                
                $sisaSaldo = $user->saldo - intval($produk->price);
           
                $user->saldo = $sisaSaldo;
                $user->save();
          
                // Proses Transaksi
                $antrian                  = new Antriantrx();
                $antrian->apiserver_id    = $apiserver_id;
                $antrian->code            = $product_id;
                $antrian->produk          = $produk->product_name;
                $antrian->harga_default   = !empty($user->referred_by) ? ($produk->price - upline_markup()) : $produk->price_default;
                $antrian->harga_markup    = !empty($user->referred_by) ? upline_markup() : $produk->price_markup;
                $antrian->target          = $target;
                $antrian->via             = 'DIRECT';
              
                if (!empty($no_meter_pln)) {
                    $antrian->mtrpln = $no_meter_pln;
                }

                $antrian->note    = "Transaksi dalam antrian.";
                $antrian->status  = 0;  // Status Proses
            
                $mutasi           = new Mutasi();
                $mutasi->user_id  = $user->id;
                $mutasi->type     = 'debit';
                $mutasi->nominal  = $produk->price;
                $mutasi->saldo    = $sisaSaldo;
                $mutasi->note     = !empty($no_meter_pln) ? 'TRANSAKSI '.$produk->product_name.' '.$no_meter_pln : 'TRANSAKSI '.$produk->product_name.' '.$target;
                $mutasi->save();

                $antrian->pengirim = $ip_address;
                $antrian->user_id = $user->id; 
                $antrian->save();
                
                DB::commit();
              
                $checkantrian = Antriantrx::findOrFail($antrian->id);
              
                if($checkantrian->status == 0) {

                    $antrian_id      = $antrian->id;
                    $mutasi_id       = $mutasi->id;
                    $code            = $produk->product_id;
                    $via             = 'DIRECT';
                    $jenis_transaksi = 'otomatis';
                  
                    usleep(500000); // 0,5 detik
                  
                    dispatch_now(new QueuePembelian($apiserver_id,$produk, $type, $code, $target, $no_meter_pln, $user, $ip_address, $antrian_id, $mutasi_id, $via, $jenis_transaksi));
                }
                
                $request->session()->regenerateToken();
              
                return redirect()->back()->with('alert-success', 'Pembelian anda telah diantrikan. Silahkan Lihat Di <a href="'.url('/member/riwayat-transaksi').'" style="font-weight:bold;text-decoration:underline;">RIWAYAT TRANSAKSI</a> untuk melihat detail pembelian. Tuliskan pengalaman bertransaksi anda bersama kami <a href="'.url('/member/testimonial').'" style="font-weight:bold;text-decoration:underline;">KIRIM TESTIMONIAL</a>.');
            }
            catch (\Exception $e)
            {
                DB::rollback();
                Log::error($e);
                return redirect()->back()->with('alert-error', $e->getMessage());
            }
        }
    }
    
    public function orderproducthome(Request $request)
    {
            sleep(1);
            
            if (!$request->isMethod('post')) {
                return Response::json(['success' => false ,'message' => 'Transaksi tidak diproses. silahkan ulangi.[err01].']);
            }

            if( (date("G") >= 23) && (intval(date("i")) >= 30) )
            {
                return Response::json(['success' => false ,'message' => 'Transaksi tidak diproses. Sedang maintenance harian. Silahkan ulangi setelah pukul 00:00 WIB.']);
            }

            if($this->settings->status == 0 || $this->settings->status_server == 0){
                return Response::json(['success' => false ,'message' => 'Sistem Sedang Maintenance, mohon kesabarannya menunggu.']);
            }
            
            if( $this->settings->force_verification == 1 )
            {
                $verification = DB::table('users_validations')
                            ->select('*')
                            ->where('user_id', auth()->user()->id)
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

            $v = Validator::make($request->all(), [
                'produk' => 'required',
                'target' => 'required',
                'pin'    => 'required',
            ],[
                'produk.required' => 'Produk tidak boleh kosong',
                'target.required' => 'Nomor Handphone / Rekening Pengisian tidak boleh kosong',
                'pin.required'    => 'PIN tidak boleh kosong',
            ]);
            
            if( $v->fails() ) {
                return Response::json([ 'success' => false, 'message' => $v->errors()->first()]);
            }
            
            $userCek  = User::where('id',Auth::user()->id)->first();
          
            $cekTarget    = BlockPhone::where('phone',trim(isset($request->target)?$request->target:$request->phone))->first();
            $cekPhoneUser = BlockPhone::where('phone',trim($userCek->phone))->first();
            
            if($userCek->status == 0) {
              return Response::json(['success' => false ,'message' => 'Maaf, Akun anda di nonaktifkan!']);
            }
            
            if($userCek->status_saldo == 0){
                return Response::json(['success'=>false,'message'=>'Maaf, saldo dikunci oleh admin dan tidak bisa digunakan']);
            }

            if( !is_null($cekTarget) || !is_null($cekPhoneUser) ){
                return Response::json(['success' => false ,'message' => 'No.Target termasuk nomor yang tercatat dalam daftar Blacklist Kami.']);
            }


            if( $userCek->pin != $request->pin ){
                return Response::json(['success' => false ,'message' => 'Maaf, Pin anda salah!']);
            }

            // Deklarasi Variable ====================================
            
            $nameTableTemp   = Uuid::generate(5, strtotime("now"), Uuid::NS_DNS);
            $createTemporary = Schema::create($nameTableTemp, function (Blueprint $table) {
              $table->engine = 'InnoDB';
              $table->increments('id');
              $table->string('apiserver_id')->nullable();
              $table->string('type');
              $table->string('produk');
              $table->string('target');
              $table->string('no_meter_pln')->nullable();
              $table->timestamps();
              $table->temporary();
            });
          
            if (Schema::hasTable($nameTableTemp))
            {
                Schema::drop($nameTableTemp);
                return Response::json(['success' => false ,'message' => 'Transaksi Tidak Diproses. Ulangi transaksi[err-temp01].']);
            }

            #insert ke table temporary. jika paramnya member tidak ada maka memasukkan pararam dari API
            $cekcode = Pembelianproduk::where(['product_id'=>$request->produk])->first();
            
            if(empty($cekcode)){
                return Response::json(['success'=>false,'message'=>'Code produk tidak ditemukan']);
            }
            
            DB::table($nameTableTemp)
                    ->insert([
                      'apiserver_id'    =>$cekcode->apiserver_id,
                      'type'            => $request->type,
                      'produk'          => $request->produk,
                      'target'          => $request->target,
                      'no_meter_pln'    => !empty($request->no_meter_pln) ? $request->no_meter_pln : NULL,
                    ]);

            $check_temp = DB::table($nameTableTemp)
                  ->select('*')
                  ->where('id', '1')
                  ->first();
            
            $apiserver_id = $check_temp->apiserver_id;
            $type         = $check_temp->type;
            $product_id   = $check_temp->produk;
            $target       = $check_temp->target;
            $no_meter_pln = $check_temp->no_meter_pln;


            $drob_temp = Schema::drop($nameTableTemp);

            $produk = produkMembershipAuth($product_id);
           

            $user         = Auth::user();
       
            $ip_address   = $request->ip();
           
            $transaksi    = Transaksi::where('code', $product_id)->where('target', $target)->whereIn('status', [0, 1])->whereDate('created_at', '=', date('Y-m-d'))->first();
          
            $queue        = Antriantrx::where('code', $product_id)->where('target', $target)->where('status', 0)->whereDate('created_at', '=', date('Y-m-d'))->first();
            
            $currentBalance = $user->saldo;
            $currentBalance = is_numeric($currentBalance) ? $currentBalance : 0;
            
            if( $currentBalance < $produk->price )
            {
                return Response::json(['success' => false ,'message' => 'Transaksi Tidak Diproses. Saldo tidak cukup untuk transaksi ini, silahkan isi saldo anda terlebih dahulu.']);
            }
            elseif( !empty($queue) )
            {
              return Response::json(['success'=>false,'message'=>'Transaksi '.$produk->product_name.' '.$target.' sudah pernah dilakukan pada '.strftime("%d %b %Y %H:%M", strtotime($queue->created_at)).' status DALAM ANTRIAN']);
            }
            elseif( !empty($transaksi) )
            {
                return Response::json(['success'=>false,'message'=>'Transaksi '.$produk->product_name.' '.$target.' sudah pernah dilakukan pada '.strftime("%d %b %Y %H:%M", strtotime($transaksi->created_at)).'. Mohon gunakan nominal atau nomor tujuan yang berbeda']);
            }
            else
            {
                // get last trx
                $ltx = Antriantrx::where('code', $product_id)->where('target', $target)->where('created_at', '>=', Carbon::now()->subMinutes(5)->toDateTimeString())->count();
                if( $ltx > 0 ) {
                    return Response::json(['success' => false, 'message' => 'Mohon tunggu 5 menit sebelum mengulai transaksi yang sama atau cek riwayat transaksi Anda']);
                }
            
                DB::beginTransaction();

                try
                {
                  $sisaSaldo = $currentBalance - $produk->price;
                  $user->saldo = $sisaSaldo;
                  $user->save();

                  $antrian = new Antriantrx();
                  $antrian->apiserver_id    = $apiserver_id;
                  $antrian->code            = $product_id;
                  $antrian->produk          = $produk->product_name;
                  $antrian->harga_default   = !empty($user->referred_by) ? ($produk->price - upline_markup()) : $produk->price_default;
                  $antrian->harga_markup    = !empty($user->referred_by) ? upline_markup() : $produk->price_markup;
                  $antrian->target          = $target;
                  $antrian->via             = 'DIRECT';
              
                  if (!empty($no_meter_pln)) {
                      $antrian->mtrpln = $no_meter_pln;
                  }
  
                  $antrian->note = "Transaksi dalam antrian.";
                  $antrian->status = 0;  // Status Proses
                
                  
                  $mutasi           = new Mutasi();
                  $mutasi->user_id  = $user->id;
                  $mutasi->type     = 'debit';
                  $mutasi->nominal  = $produk->price;
                  $mutasi->saldo    = $sisaSaldo;
                  $mutasi->note     = !empty($no_meter_pln) ? 'TRANSAKSI '.$produk->product_name.' '.$no_meter_pln : 'TRANSAKSI '.$produk->product_name.' '.$target;
                  $mutasi->save();
                  
                  $antrian->pengirim    = $ip_address;
                  $antrian->user_id     = $user->id; 
                  $antrian->save();

                  DB::commit();
                  
                  $checkantrian = Antriantrx::findOrFail($antrian->id);
                  
                  if($checkantrian->status == 0) {
                      
                      $antrian_id      = $antrian->id;
                      $mutasi_id       = $mutasi->id;
                      $code            = $produk->product_id;
                      $via             = 'DIRECT';
                      $jenis_transaksi = 'otomatis';
                      
                      usleep(500000); // 0,5 detik
                      
                      dispatch_now(new QueuePembelian($apiserver_id,$produk, $type, $code, $target, $no_meter_pln, $user, $ip_address, $antrian_id, $mutasi_id, $via, $jenis_transaksi));
                  }
                
                  $request->session()->regenerateToken();
                  
                  return Response::json(['success' => true ,'message' => 'Pembelian anda telah diantrikan. Silahkan Lihat Di <a href="/member/riwayat-transaksi" style="font-weight:bold;text-decoration:underline;">RIWAYAT TRANSAKSI</a> untuk melihat detail pembelian. Tuliskan pengalaman bertransaksi anda bersama kami <a href="/member/testimonial" style="font-weight:bold;text-decoration:underline;">KIRIM TESTIMONIAL</a>.']);
                }
                catch (\Exception $e)
                {
                  DB::rollback();
                  return Response::json(['success' => false ,'message' =>$e->getMessage()]);
                }
          }
    }

    
}