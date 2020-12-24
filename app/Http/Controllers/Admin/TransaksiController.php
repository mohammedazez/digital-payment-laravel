<?php

namespace App\Http\Controllers\Admin;

use Pulsa, Response, Freesms4Us, Notif;
use App\User;
use App\AppModel\Mutasi;
use App\AppModel\Antriantrx;
use App\AppModel\Transaksi;
use App\AppModel\Pembelianproduk;
use App\AppModel\Deposit;
use App\AppModel\Tagihan;
use App\AppModel\Redeem;
use App\AppModel\SMSGateway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function transaksiAntrian()
    {
        $antrianMobile = Antriantrx::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.transaksi.antrian.index', compact('antrianMobile'));
    }


    public function transaksiAntrianProdukDatatables(Request $request)
    {
        $columns = array(
                            0  =>'no', 
                            1  =>'code',
                            2  => 'produk',
                            3  => 'mtrpln',
                            4  => 'pengirim',
                            5  => 'via',
                            6  => 'created_at',
                            7  => 'updated_at',
                            8  => 'status',
                            9  => 'action_detail',
                            10 => 'action_hapus',
                        );
  
        $totalData = Antriantrx::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {            
            $posts = Antriantrx::offset($start)
                         ->limit($limit)
                         // ->orderBy($order,$dir)
                         ->orderBy('created_at', 'DESC')
                         ->get();
        }else {
            $search = $request->input('search.value'); 

            if(strtoupper($search) == 'PENDING'){
                $stts = '0';
            }elseif(strtoupper($search) == 'DIPROSES'){
                $stts = '1';
            }elseif(strtoupper($search) == 'GAGAL'){
                $stts = '2';
            }elseif(strtoupper($search) == 'REFUND'){
                $stts = '3';
            };
                  
            $posts =  Antriantrx::select('antriantrxes.id','antriantrxes.code','antriantrxes.produk','antriantrxes.target','antriantrxes.mtrpln','antriantrxes.pengirim','antriantrxes.created_at','antriantrxes.updated_at','antriantrxes.status','users.id as usid','users.name')
                            ->leftjoin('users','antriantrxes.user_id','users.id')
                            ->where('antriantrxes.code','LIKE',"%{$search}%")
                            ->orWhere('antriantrxes.produk', 'LIKE',"%{$search}%")
                            ->orWhere('antriantrxes.target', 'LIKE',"%{$search}%")
                            ->orWhere('antriantrxes.mtrpln', 'LIKE',"%{$search}%")
                            ->orWhere('antriantrxes.via', 'LIKE',"%{$search}%")
                            ->orWhere('users.name', 'LIKE',"%{$search}%")
                            ->orWhere('antriantrxes.status', @$stts)
                            ->offset($start)
                            ->limit($limit)
                            // ->orderBy($order,$dir)
                            ->orderBy('antriantrxes.created_at', 'DESC')
                            ->get();

            $totalFiltered = Antriantrx::select('antriantrxes.id','antriantrxes.code','antriantrxes.produk','antriantrxes.target','antriantrxes.mtrpln','antriantrxes.pengirim','antriantrxes.created_at','antriantrxes.updated_at','antriantrxes.status','users.id as usid','users.name')
                            ->leftjoin('users','antriantrxes.user_id','users.id')
                            ->where('antriantrxes.code','LIKE',"%{$search}%")
                            ->orWhere('antriantrxes.produk', 'LIKE',"%{$search}%")
                            ->orWhere('antriantrxes.target', 'LIKE',"%{$search}%")
                            ->orWhere('antriantrxes.mtrpln', 'LIKE',"%{$search}%")
                            ->orWhere('antriantrxes.via', 'LIKE',"%{$search}%")
                            ->orWhere('users.name', 'LIKE',"%{$search}%")
                            ->orWhere('antriantrxes.status', @$stts)
                            ->orderBy('antriantrxes.created_at', 'DESC')
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
                $nestedData['code']          = $post->code;
                $nestedData['produk']        = $post->produk.'<br>'.$post->target;
                $nestedData['mtrpln']        = $post->mtrpln;
                $nestedData['pengirim']      = '<td><a href="'.url('/admin/users', (isset($post->user->id)?''.$post->user->id.'':''.$post->usid.'')).'" class="btn-loading">'.(isset($post->user->name)?''.$post->user->name.'':''.$post->name.'').'</a><br>'.$post->pengirim.'</td>';
                $nestedData['via']           = '<code>'.$post->via.'</code>';
                $nestedData['created_at']    = Carbon::parse($post->created_at)->format('d M Y H:i:s');
                $nestedData['updated_at']    = Carbon::parse($post->updated_at)->format('d M Y H:i:s');
                if($post->status == 0){
                    $nestedData['status'] = '<td><span class="label label-warning">PENDING</span></td>';
                }elseif($post->status == 1){
                    $nestedData['status'] = '<td><span class="label label-success">DIPROSES</span></td>';
                }else{
                    $nestedData['status'] = '<td><span class="label label-danger">GAGAL</span></td>';
                }

                $nestedData['action_detail'] = '<a href="'.url('/admin/transaksi/antrian', $post->id).'" class="btn-loading btn btn-primary btn-sm" style="padding: 2px 5px;font-size:10px;">Detail</i></a>';
                $nestedData['action_hapus']  = '<td><form method="POST" action="'.url('/admin/transaksi/antrian/hapus', $post->id).'" accept-charset="UTF-8">
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="_token" type="hidden" value="'.csrf_token().'">
                            <button class="btn btn-danger btn-sm" onClick=\"return confirm(Anda yakin akan menghapus data ?")\" type="submit" style="padding: 2px 5px;font-size:10px;">Hapus</button>
                            </form></td>';
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
    
    public function showTransaksiAntrian($id)
    {
        $antrian = Antriantrx::findOrFail($id);
        return view('admin.transaksi.antrian.show', compact('antrian'));
    }

    public function transaksiAntrianHapus($id)
    {
        DB::beginTransaction();
        try{
            $antrian = Antriantrx::findOrFail($id);
            $antrian->delete();
            DB::commit();
            return redirect()->back()->with('alert-success', 'Berhasil Mengahpus Data Antrian');
        }catch(\Exception $e){
            DB::rollback();
            return $e;
        }
    }

    public function transaksiProduk()
    {
        $transaksiProdukMobile = Transaksi::where('tagihan_id','=',NULL)->orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.transaksi.produk.index', compact('transaksiProdukMobile'));
    }

    public function transaksiProdukDatatables(Request $request)
    {
        $columns = array( 
                            0  =>'no', 
                            1  =>'id',
                            2  => 'produk',
                            3  => 'mtrpln',
                            4  => 'pengirim',
                            5  => 'via',
                            6  => 'created_at',
                            7  => 'updated_at',
                            8  => 'status',
                            9  => 'action_detail',
                            10 => 'action_hapus',
                        );
  
        $totalData = Transaksi::where('tagihan_id','=',NULL)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {            
            $posts = Transaksi::where('tagihan_id','=',NULL)
                                ->offset($start)
                                ->limit($limit)
                                // ->orderBy($order,$dir)
                                ->orderBy('created_at', 'DESC')
                                ->get();
        }
        else {
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
                  
            $posts =  Transaksi::select('transaksis.id','transaksis.tagihan_id','transaksis.produk','transaksis.target','transaksis.mtrpln','transaksis.pengirim','transaksis.created_at','transaksis.updated_at','transaksis.status','users.id as usid','users.name')
                            ->leftjoin('users','transaksis.user_id','users.id')
                            ->where('transaksis.tagihan_id','=',NULL)
                            ->where(function($q) use ($search, $stts){
                                    $q->where('transaksis.id','LIKE',"%{$search}%");
                                    $q->orWhere('transaksis.produk', 'LIKE',"%{$search}%");
                                    $q->orWhere('transaksis.target', 'LIKE',"%{$search}%");
                                    $q->orWhere('transaksis.mtrpln', 'LIKE',"%{$search}%");
                                    $q->orWhere('transaksis.via', 'LIKE',"%{$search}%");
                                    $q->orWhere('users.name', 'LIKE',"%{$search}%");
                                    if($stts != null){
                                        $q->orWhere('transaksis.status', $stts);
                                    }
                                 })
                            ->offset($start)
                            ->limit($limit)
                            // ->orderBy($order,$dir)
                            ->orderBy('transaksis.created_at', 'DESC')
                            ->get();

            $totalFiltered = Transaksi::select('transaksis.id','transaksis.tagihan_id','transaksis.produk','transaksis.target','transaksis.mtrpln','transaksis.pengirim','transaksis.created_at','transaksis.updated_at','transaksis.status','users.id as usid','users.name')
                            ->leftjoin('users','transaksis.user_id','users.id')
                            ->where('transaksis.tagihan_id','=',NULL)
                            ->where(function($q) use ($search, $stts){
                                    $q->where('transaksis.id','LIKE',"%{$search}%");
                                    $q->orWhere('transaksis.produk', 'LIKE',"%{$search}%");
                                    $q->orWhere('transaksis.target', 'LIKE',"%{$search}%");
                                    $q->orWhere('transaksis.mtrpln', 'LIKE',"%{$search}%");
                                    $q->orWhere('transaksis.via', 'LIKE',"%{$search}%");
                                    $q->orWhere('users.name', 'LIKE',"%{$search}%");
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
                $nestedData['no']            = $start+$no;
                $nestedData['id']            = $post->id;
                $nestedData['produk']        = $post->produk.'<br>'.$post->target;
                $nestedData['mtrpln']        = $post->mtrpln;
                $nestedData['pengirim']      = '<td><a href="'.url('/admin/users', (isset($post->user->id)?''.$post->user->id.'':''.$post->usid.'')).'" class="btn-loading">'.(isset($post->user->name)?''.$post->user->name.'':''.$post->name.'').'</a><br>'.$post->pengirim.'</td>';
                $nestedData['via']           = '<code>'.$post->via.'</code>';
                $nestedData['created_at']    = Carbon::parse($post->created_at)->format('d M Y H:i:s');
                $nestedData['updated_at']    = Carbon::parse($post->updated_at)->format('d M Y H:i:s');
                if($post->status == 0){
                    $nestedData['status'] = '<td><span class="label label-warning">PROSES</span></td>';
                }elseif($post->status == 1){
                    $nestedData['status'] = '<td><span class="label label-success">BERHASIL</span></td>';
                }elseif($post->status == 2){
                    $nestedData['status'] = '<td><span class="label label-danger">GAGAL</span></td>';
                }elseif($post->status == 3){
                    $nestedData['status'] = '<td><span class="label label-primary">REFUND</span></td>';
                };
                $nestedData['action_detail'] = '<a href="'.url('/admin/transaksi/produk', $post->id).'" class="btn-loading btn btn-primary btn-sm" style="padding: 2px 5px;font-size:10px;">Detail</i></a>';
                $nestedData['action_hapus']  = '<td><form method="POST" action="'.url('/admin/transaksi/produk/hapus', $post->id).'" accept-charset="UTF-8">
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="_token" type="hidden" value="'.csrf_token().'">
                            <button class="btn btn-danger btn-sm" onClick=\"return confirm(Anda yakin akan menghapus data ?")\" type="submit" style="padding: 2px 5px;font-size:10px;">Hapus</button>
                            </form></td>';
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
    
    
    public function showTransaksiProduk($id)
    {
        $transaksiProduk = Transaksi::where(['id' => $id, 'tagihan_id' => NULL])->firstOrFail();
        return view('admin.transaksi.produk.show', compact('transaksiProduk'));
    }

    public function transaksiHapus($id)
    {
        DB::beginTransaction();
        try{
            $transaksiProduk = Transaksi::findOrFail($id);
            $transaksiProduk->delete();
            DB::commit();
            return redirect()->back()->with('alert-success', 'Berhasil Menghapus Data Order');
        }catch(\Exception $e){
            DB::rollback();
            return $e;
        }
    }
    
    public function refundTransaksiProduk(Request $request, $id)
    {
        DB::beginTransaction();
        try{
            $transaksi = Transaksi::findOrFail($id);
            $produk = Pembelianproduk::where('product_id', $transaksi->code)->first();
            $hargaProduk = $produk->price;
        
            $users = User::findOrFail($transaksi->user_id);
            $sisaSaldo = $users->saldo + $hargaProduk;
            $users->saldo = $sisaSaldo;
            $users->save();
        
            $mutasi = new Mutasi();
            $mutasi->user_id = $users->id;
            $mutasi->trxid = $transaksi->id;
            $mutasi->type = 'credit';
            $mutasi->nominal = $hargaProduk;
            $mutasi->saldo  = $sisaSaldo;
            $mutasi->note  = 'REFUND TRX '.$produk->product_name.' '.$transaksi->target;
            $mutasi->save();
        
            $transaksi->note = "[manual] Trx Direfund";
            $transaksi->status = 3;
            $transaksi->saldo_after_trx = $transaksi->saldo_before_trx;
            $transaksi->save();
            
            DB::commit();
            
            return Response::json($transaksi);
        }catch(\Exception $e){
            DB::rollback();
            return $e;
        }
    }

    public function ubahStatusTransaksiProduk(Request $request, $id)
    {
        DB::beginTransaction();
        try{
            $transaksi = Transaksi::findOrFail($id);
            
            if($request->stt == 0)
            {
                $transaksi->note = "[manual] Transaksi berhasil diproses";
                $transaksi->token = $request->sn;
            }
            elseif($request->stt == 1)
            {
                $transaksi->note = "[manual] Transaksi success";
                $transaksi->token = $request->sn;
            }
            elseif($request->stt == 2)
            {
                $transaksi->note = "[manual] Transaksi gagal";
                $transaksi->token = $request->sn;
                
                if( in_array($transaksi->status, [0, 1]) )
                {
                    $users = User::findOrFail($transaksi->user_id);
                    $sisaSaldo = $users->saldo + $transaksi->total;
                    $users->saldo = $sisaSaldo;
                    $users->save();
                    
                    $mutasi = new Mutasi();
                    $mutasi->trxid = $transaksi->id;
                    $mutasi->user_id = $users->id;
                    $mutasi->type = 'credit';
                    $mutasi->nominal = $transaksi->total;
                    $mutasi->saldo  = $sisaSaldo;
                    $mutasi->note  = $transaksi->mtrpln != '-' ? 'TRANSAKSI '.$transaksi->produk.' '.$transaksi->mtrpln.' GAGAL' : 'TRANSAKSI '.$transaksi->produk.' '.$transaksi->target.' GAGAL';
                    $mutasi->save();
                    
                    //hapus temptransaksis
                     DB::table('temptransaksis')
                        ->where('transaksi_id', $transaksi->id)
                        ->delete();
                }
            }
            
            $transaksi->status = $request->stt;
            $transaksi->save();
            
            DB::commit();
            
            return Response::json($transaksi);
        }catch(\Exception $e){
            DB::rollback();
            return $e;
        }
    }
    
    public function transaksiSaldo()
    {
        $depositsMobile = Deposit::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.transaksi.deposit.index', compact('depositsMobile'));
    }

    public function transaksiSaldoDatatables(Request $request)
    {
        $columns = array( 
                            0 =>'no', 
                            1 =>'id',
                            2=> 'nama_bank',
                            3=> 'nominal_trf',
                            4=> 'status',
                            5=> 'expire',
                            6=> 'name',
                            7=> 'updated_at',
                            8=> 'action_detail',
                            9=> 'action_hapus',
                        );
  
        $totalData = Deposit::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {            
            $posts = Deposit::offset($start)
                         ->limit($limit)
                         // ->orderBy($order,$dir)
                         ->orderBy('created_at', 'DESC')
                         ->get();
        }else {
            $search = $request->input('search.value'); 

            if(strtoupper($search) == 'MENUNGGU'){
                $stts = '0';
            }elseif(strtoupper($search) == 'BERHASIL'){
                $stts = '1';
            }elseif(strtoupper($search) == 'GAGAL'){
                $stts = '2';
            }elseif(strtoupper($search) == 'VALIDASI'){
                $stts = '3';
            };

            if(strtoupper($search) == 'AKTIF'){
                $stts = '0';
            }elseif(strtoupper($search) == 'EXPIRED'){
                $stts = '1';
            };

            $posts =  Deposit::select('deposits.id','banks.nama_bank','deposits.nominal','deposits.nominal_trf','deposits.status','deposits.expire','deposits.updated_at','users.id as usid','users.name')
                            ->leftjoin('users','deposits.user_id','users.id')
                            ->leftjoin('banks','deposits.bank_id','banks.id')
                            ->where('deposits.id','LIKE',"%{$search}%")
                            ->orWhere('banks.nama_bank', 'LIKE',"%{$search}%")
                            ->orWhere('deposits.expire', @$exp)
                            ->orWhere('deposits.status', @$stts)
                            ->orWhere('users.name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            // ->orderBy($order,$dir)
                            ->orderBy('deposits.created_at', 'DESC')
                            ->get();

            $totalFiltered = Deposit::select('deposits.id','banks.nama_bank','deposits.nominal','deposits.nominal_trf','deposits.status','deposits.expire','deposits.updated_at','users.id as usid','users.name')
                            ->leftjoin('users','deposits.user_id','users.id')
                            ->leftjoin('banks','deposits.bank_id','banks.id')
                            ->where('deposits.id','LIKE',"%{$search}%")
                            ->orWhere('banks.nama_bank', 'LIKE',"%{$search}%")
                            ->orWhere('deposits.expire', @$exp)
                            ->orWhere('deposits.status', @$stts)
                            ->orWhere('users.name', 'LIKE',"%{$search}%")
                            ->orderBy('deposits.created_at', 'DESC')
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
                $nestedData['id']            = $post->id;
                $nestedData['nama_bank']     = (isset($post->bank->nama_bank)?''.$post->bank->nama_bank.'':''.$post->nama_bank.'');

                if($post->bank_id == '5'){
                    $nestedData['nominal_trf'] = '<td>Rp. '.number_format($post->nominal, 0, '.', '.').' ('.$post->nominal_trf.')';
                }else{
                    $nestedData['nominal_trf'] = '<td>Rp. '.number_format($post->nominal_trf, 0, '.', '.');
                }

                if($post->status == 0){
                    $nestedData['status'] = '<td><span class="label label-warning">MENUNGGU</span></td>';
                }elseif($post->status == 1){
                    $nestedData['status'] = '<td><span class="label label-success">BERHASIL</span></td>';
                }elseif($post->status == 2){
                    $nestedData['status'] = '<td><span class="label label-danger">GAGAL</span></td>';
                }elseif($post->status == 3){
                    $nestedData['status'] = '<td><span class="label label-primary">VALIDASI</span></td>';
                };

                if($post->expire == 1){
                    $nestedData['expire'] = '<td><span class="label label-info">AKTIF</span></td>';
                }else{
                    $nestedData['expire'] = '<td><span class="label label-danger">EXPIRED</span></td>';
                };

                 $nestedData['name']      ='<td><div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><a href="'.url('/admin/users', (isset($post->user->id)?''.$post->user->id.'':''.$post->usid.'')).'" class="btn-loading">'.(isset($post->user->name)?''.$post->user->name.'':''.$post->name.'').'</a></div></td>';

                $nestedData['updated_at']    = Carbon::parse($post->updated_at)->format('d M Y H:i:s');

                $nestedData['action_detail'] = '<a href="'.url('/admin/transaksi/deposit/show', $post->id).'" class="btn-loading btn btn-primary btn-sm" style="padding: 2px 5px;font-size:10px;">Detail</i></a>';
                $nestedData['action_hapus']  = '<td><form method="POST" action="'.url('/admin/transaksi/deposit/hapus', $post->id).'" accept-charset="UTF-8">
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="_token" type="hidden" value="'.csrf_token().'">
                            <button class="btn btn-danger btn-sm" onClick=\"return confirm(Anda yakin akan menghapus data ?")\" type="submit" style="padding: 2px 5px;font-size:10px;">Hapus</button>
                            </form></td>';
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

    public function depositShow($id)
    {
        $deposits = Deposit::findOrFail($id);
        return view('admin.transaksi.deposit.show', compact('deposits'));
    }
    
    public function cekPembayaranExp()
    {
        DB::beginTransaction();
        try{
            $tagihan = Tagihan::where('expired',1)->get();
            $results = array();
            foreach($tagihan as $item){
                $now = date("Y-m-d H:i:s");
                $awal = strtotime(date("Y-m-d H:i:s", strtotime($item->created_at)));
                $akhir = strtotime(date("Y-m-d H:i:s"));
                $diff  = $akhir - $awal;
                
                $jam   = floor($diff / (60 * 60));
                $menit = $diff - $jam * (60 * 60);
                
                //3 HARI
                if($jam >= 72.0){
                    $tagihan          = Tagihan::findOrFail($item->id);
                    $tagihan->expired = '0';
                    $tagihan->status  = '3';
                    $tagihan->save();
                }
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return $e;
        }
        
    }
    
    public function cekDepo()
    {
        DB::beginTransaction();
        try{
            $deposits = Deposit::where(['status'=> 0, 'expire'=>1])->get();
            $results = array();
            foreach($deposits as $item){
                $now = date("Y-m-d H:i:s");
                $awal = strtotime(date("Y-m-d H:i:s", strtotime($item->created_at)));
                $akhir = strtotime(date("Y-m-d H:i:s"));
                $diff  = $akhir - $awal;
                
                $jam   = floor($diff / (60 * 60));
                $menit = $diff - $jam * (60 * 60);
                if($jam >= 24.0){
                    $updateDeposit         = Deposit::find($id);
                    $updateDeposit->status = 2;
                    $updateDeposit->expire = 0;
                    $updateDeposit->save();
                }
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return $e;
        }
    }
    
    public function depositMenunggu($id)
    {
        DB::beginTransaction();
        try{
            $deposits = Deposit::findOrFail($id);
            if($deposits->status == 3){
                $deposits->note = "Menunggu pembayaran sebesar Rp ".number_format($deposits->nominal_trf, 0, '.', '.');
                $deposits->status = 0;
                $deposits->save();
                DB::commit();
                return redirect()->back();
            }else{
                return redirect()->back()->with('alert-error', 'Perubahan status tidak dapat dilakukan, pastikan status deposit adalah VALIDASI untuk melakukan perubahan status MENUNGGU');
            }
        }catch(\Exception $e){
            DB::rollback();
            return $e;
        }
        
    }
    
    public function depositValidasi($id)
    {
        DB::beginTransaction();
        try{
            $deposits = Deposit::findOrFail($id);
            if($deposits->status == 0){
                $deposits->note = "Pembayaran telah di konfirmasi, proses validasi.";
                $deposits->status = 3;
                $deposits->save();
                DB::commit();    
                return redirect()->back();
            }else{
                return redirect()->back()->with('alert-error', 'Perubahan status tidak dapat dilakukan, pastikan status deposit adalah MENUNGGU untuk melakukan perubahan status VALIDASI');
            }
        }catch(\Exception $e){
            DB::rollback();
            return $e;
        }
        
    }

    public function depositSuccess($id)
    {
        DB::beginTransaction();
        try{
            // script deposit saldo
            $deposits = Deposit::findOrFail($id);
            $deposits->status = 1;
            $deposits->expire = 0;
            $deposits->note = "Deposit sebesar Rp ".number_format($deposits->nominal_trf, 0, '.', '.')." berhasil ditambahkan, saldo sekarang Rp ".number_format($deposits->user->saldo + $deposits->nominal_trf, 0, '.', '.');
            $deposits->save();
    
            $users = User::findOrFail($deposits->user_id);
            $saldo = $users->saldo + $deposits->nominal_trf;
            $users->saldo = $saldo;
            $users->save();
            
            $pesan = 'Yth. '.$users->name.', Deposit Rp '.number_format($deposits->nominal_trf, 0, '.', '.').' SUKSES via '.$deposits->bank->nama_bank.'. Saldo sekarang Rp '.number_format($saldo, 0, '.', '.');
            $notification = SMSGateway::send($users->phone, $pesan);
            
            $mutasi = new Mutasi();
            $mutasi->user_id = $users->id;
            $mutasi->trxid = $deposits->id;
            $mutasi->type = 'credit';
            $mutasi->nominal = $deposits->nominal_trf;
            $mutasi->saldo  = $saldo;
            $mutasi->note  = 'DEPOSIT/TOP-UP SALDO';
            $mutasi->save();
            
            DB::commit();
            return redirect()->back()->with('alert-success', 'Berhasil Melakukan Perubahan Status Request Deposit');
        }catch(\Exception $e){
            DB::rollback();
            return $e;
        }
    }

    public function depositGagal($id)
    {
        DB::beginTransaction();
        try{
            $deposits = Deposit::findOrFail($id);
            $deposits->status = 2;
            $deposits->expire = 0;
            $deposits->note = "Deposit GAGAL, silahkan lakukan kembali request deposit di menu TOP-UP Saldo.";
            $deposits->save();
            DB::commit();
            return redirect()->back()->with('alert-success', 'Berhasil Melakukan Perubahan Status Request Deposit');
        }catch(\Exception $e){
            DB::rollback();
            return $e;
        }
    }

    public function depositHapus($id)
    {
        DB::beginTransaction();
        try{
            $deposits = Deposit::findOrFail($id);
            $deposits->delete();
            
            DB::commit();
            return redirect()->back()->with('alert-success', 'Berhasil Melakukan Perubahan Status Request Deposit');
        }catch(\Exception $e){
            DB::rollback();
            return $e;
        }
    }
    
    public function transaksiTagihan()
    {
        $tagihanMobile = Tagihan::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.transaksi.tagihan.index', compact('tagihanMobile'));
    }

    public function transaksiTagihanDatatables(Request $request)
    {
        $columns = array( 
                            0 =>'no', 
                            1 =>'tagihan_id',
                            2=> 'product_name',
                            3=> 'nama',
                            4=> 'jumlah_bayar',
                            5=> 'pengirim',
                            6=> 'via',
                            7=> 'status',
                            8=> 'expired',
                            9=> 'created_at',
                            10=> 'action_detail',
                            11=> 'action_hapus',
                        );
  
        $totalData = Tagihan::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {            
            $posts = Tagihan::offset($start)
                         ->limit($limit)
                         ->orderBy('created_at', 'DESC')
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            if(strtoupper($search) == 'MENUNGGU'){
                $stts = 0;
            }elseif(strtoupper($search) == 'PROSES'){
                $stts = 1;
            }elseif(strtoupper($search) == 'BERHASIL'){
                $stts = 2;
            }elseif(strtoupper($search) == 'GAGAL'){
                $stts = 3;
            }elseif(strtoupper($search) == 'REFUND'){
                $stts = 4;
            };

            if(strtoupper($search) == 'AKTIF'){
                $exp = 1;
            }elseif(strtoupper($search) == 'EXPIRED'){
                $exp = 0;
            };
                  
            $posts =  Tagihan::select('tagihans.id','tagihans.tagihan_id','tagihans.product_name','tagihans.no_pelanggan','tagihans.nama','tagihans.jumlah_bayar','tagihans.periode','tagihans.created_at','tagihans.updated_at','tagihans.status','tagihans.expired','users.id as usid','users.name')
                            ->leftjoin('users','tagihans.user_id','users.id')
                            ->where('tagihans.tagihan_id','LIKE',"%{$search}%")
                            ->orWhere('tagihans.product_name', 'LIKE',"%{$search}%")
                            ->orWhere('tagihans.no_pelanggan', 'LIKE',"%{$search}%")
                            ->orWhere('tagihans.nama', 'LIKE',"%{$search}%")
                            ->orWhere('tagihans.via', 'LIKE',"%{$search}%")
                            ->orWhere('users.name', 'LIKE',"%{$search}%")
                            ->orWhere('tagihans.expired', @$exp)
                            ->orWhere('tagihans.status', @$stts)
                            ->offset($start)
                            ->limit($limit)
                            // ->orderBy($order,$dir)
                            ->orderBy('tagihans.created_at', 'DESC')
                            ->get();

            $totalFiltered = Tagihan::select('tagihans.id','tagihans.tagihan_id','tagihans.product_name','tagihans.no_pelanggan','tagihans.nama','tagihans.jumlah_bayar','tagihans.periode','tagihans.created_at','tagihans.updated_at','tagihans.status','tagihans.expired','users.id as usid','users.name')
                            ->leftjoin('users','tagihans.user_id','users.id')
                            ->where('tagihans.tagihan_id','LIKE',"%{$search}%")
                            ->orWhere('tagihans.product_name', 'LIKE',"%{$search}%")
                            ->orWhere('tagihans.no_pelanggan', 'LIKE',"%{$search}%")
                            ->orWhere('tagihans.nama', 'LIKE',"%{$search}%")
                            ->orWhere('tagihans.via', 'LIKE',"%{$search}%")
                            ->orWhere('users.name', 'LIKE',"%{$search}%")
                            ->orWhere('tagihans.expired', @$exp)
                            ->orWhere('tagihans.status', @$stts)
                            ->orderBy('tagihans.created_at', 'DESC')
                            ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $nestedData['tagihan_id']    = $post->tagihan_id;
                $nestedData['product_name']  = $post->product_name.'<br>'.$post->no_pelanggan;
                $nestedData['nama']          = $post->nama;
                $nestedData['jumlah_bayar']  = '<td>Rp. '.number_format($post->jumlah_bayar, 0, '.', '.').'<br>'.$post->periode.'</td>';
                $nestedData['pengirim']      = '<td><a href="'.url('/admin/users', (isset($post->user->id)?''.$post->user->id.'':''.$post->usid.'')).'" class="btn-loading">'.(isset($post->user->name)?''.$post->user->name.'':''.$post->name.'').'</a><br>'.$post->pengirim.'</td>';
                $nestedData['via']           = '<code>'.$post->via.'</code>';

                if($post->status == 0){
                    $nestedData['status'] = '<td><span class="label label-warning">MENUNGGU</span></td>';
                }elseif($post->status == 1){
                    $nestedData['status'] = '<td><span class="label label-warning">PROSES</span></td>';
                }elseif($post->status == 2){
                    $nestedData['status'] = '<td><span class="label label-success">BERHASIL</span></td>';
                }else{
                    $nestedData['status'] = '<td><span class="label label-danger">GAGAL</span></td>';
                };

                if($post->expired == 1){
                    $nestedData['expired'] = '<td><span class="label label-info">AKTIF</span></td>';
                }else{
                    $nestedData['expired'] = '<td><span class="label label-danger">EXPIRED</span></td>';
                };

                $nestedData['created_at']    = Carbon::parse($post->created_at)->format('d M Y H:i:s');
                $nestedData['action_detail'] = '<a href="'.url('/admin/transaksi/tagihan', $post->id).'" class="btn-loading btn btn-primary btn-sm" style="padding: 2px 5px;font-size:10px;">Detail</i></a>';
                $nestedData['action_hapus']  = '<td><form method="POST" action="'.url('/admin/transaksi/tagihan/hapus', $post->id).'" accept-charset="UTF-8">
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="_token" type="hidden" value="'.csrf_token().'">
                            <button class="btn btn-danger btn-sm" onClick=\"return confirm(Anda yakin akan menghapus data ?")\" type="submit" style="padding: 2px 5px;font-size:10px;">Hapus</button>
                            </form></td>';
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
    
    public function showTransaksiTagihan($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        return view('admin.transaksi.tagihan.show', compact('tagihan'));
    }
    
    public function hapusTransaksiTagihan($id)
    {
        DB::beginTransaction();
        try{
            $tagihan = Tagihan::findOrFail($id);
            $tagihan->delete();
            DB::commit();
            return redirect()->back()->with('alert-success', 'Berhasil Menghapus Data Tagihan Pembayaran');
        }catch(\Exception $e){
            DB::rollback();
            return $e;
        }
    }
    
    
    
    public function tagihanMenunggu($id)
    {
        DB::beginTransaction();
        try{
            $tagihan = Tagihan::findOrFail($id);
            $tagihan->status = 0;
            $tagihan->expired = 1;
            $tagihan->save();
            DB::commit();
            return back()->with('alert-success', 'Status Data Tagihan Berhasil Dirubah');
        }catch(\Exception $e){
            DB::rollback();
            return $e;
        }
        
    }
    public function tagihanRefund($id){
        //dd('tagihanRefund');
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->status = 4;
        $tagihan->expired = 0;
        $tagihan->save();
        return back()->with('alert-success', 'Status Data Tagihan Berhasil Dirubah');
        
    }
    public function tagihanSuccess($id)
    {
        DB::beginTransaction();
        try{
            $tagihan = Tagihan::findOrFail($id);
            $tagihan->status = 2;
            $tagihan->expired = 0;
            $tagihan->save();
            DB::commit();
            return back()->with('alert-success', 'Status Data Tagihan Berhasil Dirubah');
        }catch(\Exception $e){
            DB::rollback();
            return $e;
        }
        
    }
    
    public function tagihanGagal($id)
    {
        DB::beginTransaction();
        try{
            $tagihan = Tagihan::findOrFail($id);
            $tagihan->status = 3;
            $tagihan->expired = 0;
            $tagihan->save();
            DB::commit();
            return back()->with('alert-success', 'Status Data Tagihan Berhasil Dirubah');
        }catch(\Exception $e){
            DB::rollback();
            return $e;
        }
    }
    
    public function redeem()
    {
        $redeem = Redeem::orderBy('created_at', 'DESC')->get();
        return view('admin.transaksi.redeem.index', compact('redeem'));
    }
    
    public function redeemDetail($id)
    {
        $redeem = Redeem::findOrFail($id);
        return view('admin.transaksi.redeem.show', compact('redeem'));
    }
    
    public function redeemHapus($id)
    {
        DB::beginTransaction();
        try{
            $redeem = Redeem::findOrFail($id);
            $redeem->delete();
            DB::commit();
            return redirect()->back()->with('alert-success', 'Berhasil menghapus data redeem');
        }catch(\Exception $e){
            DB::rollback();
            return $e;
        }
    }

}