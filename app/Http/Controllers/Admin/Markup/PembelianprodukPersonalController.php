<?php

namespace App\Http\Controllers\Admin\Markup;

use Pulsa, Response,DigiFlazz;
use App\AppModel\Pembeliankategori;
use App\AppModel\Pembelianoperator;
use App\AppModel\Pembelianproduk;
use App\AppModel\V_pembelianproduk_personal;
use App\AppModel\Pembelian_markup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PembelianprodukPersonalController extends Controller
{
    public function index()
    {
        $produksWeb     = V_pembelianproduk_personal::all();
        $produksMobile  = V_pembelianproduk_personal::paginate(10);

        return view('admin.markup.pembelian.personal.index', compact('produksWeb', 'produksMobile'));
    }

    public function cekHarga(Request $request)
    {
        $id   = $request->input('id');
        $type = $request->input('url_link');

       if($type == 'token-listrik'){
            $code = 'PLN';
        }else if ($type == 'voucher-game'){
            $code = 'GAME';
        }else{
            $code = 'PULSA';
        }

        $getProduk = Pulsa::produk_pembelian($code);
        
        if($getProduk->success == false ){
            return 'error';
        }else{
            $results = array();
            foreach($getProduk->data as $item){
                if($id == $item->code){
                    $results[] = [
                            'code'          =>$item->code,
                            'description'   =>$item->desc,
                            'price_api'     =>number_format($item->price,0,',','.'),
                    ];
                }
            }
        }

        return $results;
    }

    //update all data
    public function updateHargaSemua(Request $request)
    {
        DB::beginTransaction();
        try{
            $update = Pembelian_markup::where('markup_personal','<>',0)->update(['markup_personal' => 0]);
            
            DB::commit();
            if($update){
                return response()->json([
                    'success'=> true, 
                    'message'=> 'Reset all markup Personal success!', 
                ], 200);
            }else{
                return response()->json([
                    'success'=> false, 
                    'message'=> 'Reset all markup Personal failed!', 
                ], 200);
            }
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success'=> false, 
                'message'=> $e, 
            ], 200);
        }
    }


   //update data by kategori
    public function updateHaragSumMakupPerKategori(Request $request)
    {
        if(empty($request->id_kategori)){
            return response()->json([
                'success'=> false, 
                'message'=> 'Pilih opsional kategori terlebih dahulu!', 
            ], 200);
        }

        if(empty($request->aksi)){
            return response()->json([
                'success'=> false, 
                'message'=> 'Pilih aksi terlebih dahulu!', 
            ], 200);
        }

        if(empty($request->nominal) || $request->nominal == '0'){
            return response()->json([
                'success'=> false, 
                'message'=> 'Nominal tidak boleh kosong ataupun 0!', 
            ], 200);
        }


        DB::beginTransaction();
        try{
            $id_kategori  = $request->id_kategori;
            $aksi         = $request->aksi;
            $nominal      = str_replace('.','',  $request->nominal);
            $header_trans = Pembelianproduk::select('id')->where('pembeliankategori_id', $id_kategori)->get();

            foreach($header_trans as $data){
                 Pembelian_markup::where('id_product', $data->id)->update(['markup_personal'  => DB::raw('markup_personal '.$aksi.' '.intval($nominal).'')]);
            }

            DB::commit();
            return response()->json([
                'success'=> true, 
                'message'=> ''.$aksi.' '.$request->nominal.' markup Personal success!', 
            ], 200);
            
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success'=> false, 
                'message'=> $e, 
            ], 200);
        }
    }


    //update data by operator
    public function updateHaragSumMakupPerOperator(Request $request)
    {

        if(empty($request->id_operator)){
            return response()->json([
                'success'=> false, 
                'message'=> 'Pilih opsional kategori/operator terlebih dahulu!', 
            ], 200);
        }

        if(empty($request->aksi)){
            return response()->json([
                'success'=> false, 
                'message'=> 'Pilih aksi terlebih dahulu!', 
            ], 200);
        }

        if(empty($request->nominal) || $request->nominal == '0'){
            return response()->json([
                'success'=> false, 
                'message'=> 'Nominal tidak boleh kosong ataupun 0!', 
            ], 200);
        }


        DB::beginTransaction();
        try{
            $id_operator = $request->input('id_operator');
            $aksi        = $request->input('aksi');
            $nominal     = str_replace('.','',  $request->input('nominal'));
            
            $header_trans = Pembelianoperator::select('id')->where('product_id', $id_operator)->get();

            foreach($header_trans as $data){
                
                $header_trans = Pembelianproduk::select('id')->where('pembelianoperator_id', $data->id)->get();
                foreach($header_trans as $data_trans){
                    Pembelian_markup::where('id_product', $data_trans->id)->update(['markup_personal'  => DB::raw('markup_personal '.$aksi.' '.intval($nominal).'')]);
                }
            }
            DB::commit();
            return response()->json([
                'success'=> true, 
                'message'=> ''.$aksi.' '.$request->nominal.' markup Personal success!', 
            ], 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success'=> false, 
                'message'=> $e, 
            ], 200);
        }
    }


    //update data by kategori
    public function updateHargaPerKategori(Request $request)
    {
        if(empty($request->id_kategori)){
            return response()->json([
                'success'=> false, 
                'message'=> 'Pilih opsional kategori terlebih dahulu!', 
            ], 200);
        }

        DB::beginTransaction();
        try{
            
            $getPembelian = Pembelianproduk::select('id')->where('pembeliankategori_id', $request->id_kategori)->get();
            
            foreach($getPembelian as $data){
                Pembelian_markup::where('id_product', $data->id)->where('markup_personal','<>',0)->update(['markup_personal' => 0]);
            }

            DB::commit();
            return response()->json([
                'success'=> true, 
                'message'=> 'Reset all markup Personal By Kategori success!', 
            ], 200);
            
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success'=> false, 
                'message'=> $e, 
            ], 200);
        }
    }


    //update data by operator
    public function updateHargaPerOperator(Request $request)
    {
        if(empty($request->id_kategori || $request->id_operator)){
            return response()->json([
                'success'=> false, 
                'message'=> 'Pilih opsional operator/kategori terlebih dahulu!', 
            ], 200);
        }

        DB::beginTransaction();
        try{
            $query = Pembelianoperator::select('id')->where('product_id', $request->id_operator)->get();
        
            foreach($query as $data){
                $header_trans = Pembelianproduk::select('id')->where('pembelianoperator_id', $data->id)->get();
        		foreach($header_trans as $data_trans){
                    Pembelian_markup::where('id_product', $data_trans->id)->where('markup_personal','<>',0)->update(['markup_personal' => 0]);
        		}
            }
            DB::commit();
            return response()->json([
                'success'=> true, 
                'message'=> 'Reset all markup Personal By Operator success!', 
            ], 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success'=> false, 
                'message'=> $e, 
            ], 200);
        }

    }

    public function showbyKategori($title)
    {
        $kategori     = Pembeliankategori::where('slug', $title)->first();
        $operator     = Pembelianoperator::where('id', $kategori->pembelianoperator->first()->id)->first();

        $kategori_all = Pembeliankategori::all();

        return view('admin.markup.pembelian.personal.show', compact('kategori','operator','kategori_all'));
    }

    public function findproduct(Request $request)
    {
        $query = Pembelianoperator::where('pembeliankategori_id' ,$request->kategori_id)->get();
        return Response::json($query);
    }

    public function import(Request $request)
    {
        if($request->type == 1){
            $code_produk = '1';
        }elseif($request->type == 2){
            $code_produk = '2';
        }elseif($request->type == 3){
            $code_produk = '3';
        }elseif($request->type == 4){
            $code_produk = '4';
        }elseif($request->type == 5){
            $code_produk = '5';
        }
        
        $aksi    = $request->input('aksi');
        $nominal = $request->input('nominal');
        $type    = $request->input('type');

        Pembelianproduk::updateAllpriceByCategory($code_produk,$aksi,$nominal);
    }

    public function plusminusmarkupAllData(Request $request)
    {   
        if(empty($request->aksi)){
            return response()->json([
                'success'=> false, 
                'message'=> 'Pilih aksi terlebih dahulu!', 
            ], 200);
        }

        if(empty($request->nominal) || $request->nominal == '0'){
            return response()->json([
                'success'=> false, 
                'message'=> 'Nominal tidak boleh kosong ataupun 0!', 
            ], 200);
        }

        DB::beginTransaction();
        try{
            $aksi    = $request->aksi;
            $nominal = str_replace('.','',  $request->nominal);

            DB::table('pembelian_markups')->update(['markup_personal'  => DB::raw('markup_personal '.$aksi.' '.intval($nominal).'')]);
            DB::commit();
            return response()->json([
                'success'=> true, 
                'message'=> ''.$aksi.' '.$request->nominal.' markup Personal success!', 
            ], 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success'=> false, 
                'message'=> $e, 
            ], 200);
        }
    }


    public function deleteAllProduk(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $produk = Pembelianproduk::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return Response::json($produk);
    }

    public function edit($jenis,$id)
    {
        $produks  = V_pembelianproduk_personal::where('id', $id)->first();
        $operator = Pembelianoperator::where('id', $produks->pembelianoperator_id)->first();
        $kategori = Pembeliankategori::where('id', $operator->pembeliankategori_id)->first();
        $code     = $produks->product_id;
        //$produk   = DigiFlazz::EditProdukPrabayar($code);
        //$produk   = json_decode($produk);
        $produk = Pulsa::detail_produk_pembelian($code);
        $results  = array();
        if($produk->success == false ){
            return 'Api tidak terhubung';
        } else {
            $produk = $produk->data;
            
            $results[] = [
                    //'id'         =>$item->id,
                    'code'         =>$produk->code,
                    'description'  =>$produk->product_name,
                    'product_name' =>$produk->product_name,
                    // 'operator'     =>$produk->brand,
                    'price_api'    =>$produk->price,
                    'status'       =>$produk->status,
            ];

            return view('admin.markup.pembelian.personal.edit', compact('produks','results','operator'));
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'price_jual' => 'required',
        ],[
            'price_jual.required' => 'Harga Jual tidak boleh kosong',
        ]);
        
        
        $getPembelian = Pembelian_markup::where('id_product', $id)
                        ->update([
                            'markup_personal' => str_replace('.','', $request->price_markup),
                        ]);
        return redirect()->back()->with('alert-success', 'Berhasil Merubah Data Produk');
    }
    
    public function destroy($id)
    {
        $deletePembelian = Pembelian_markup::where('id_product', $id)
                            ->delete();
                            
        return redirect()->route('admin.produkPersonal.index')->with('alert-success', 'Berhasil Menghapus Data Produk');
    }
}
