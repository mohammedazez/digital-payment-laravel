<?php

namespace App\Http\Controllers\Admin;

use Pulsa, Response,DigiFlazz;
use App\AppModel\Pembeliankategori;
use App\AppModel\Pembelianoperator;
use App\AppModel\Pembelianproduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PembelianprodukController extends Controller
{
    public function index()
    {
        $produksWeb = Pembelianproduk::get();
        $produksMobile = Pembelianproduk::paginate(10);

        return view('admin.pembelian.produk.index', compact('produksWeb', 'produksMobile'));
    }

    public function cekHarga(Request $request)
    {
        return;
        $id   = $request->input('id');
        $type = $request->input('url_link');

       if($type == 'token-listrik'){
            $code = 'PLN';
        }else if ($type == 'voucher-game'){
            $code = 'GAME';
        }else{
            $code = 'PULSA';
        }

        return [];
    }

    //Update by CHECKLIST
    public function updateHargaPerChecklist(Request $request)
    {
        return;
        $product_id = array();
        $code       = array();
        $o          = count($request->datachecked);
        for($i = 0; $i < $o; $i++){
            array_push($product_id, $request->datachecked[$i][0]['value']);
            array_push($code, $request->datachecked[$i][1]['value']);
        }

        $type = $request->input('jenis_produk');
        
        if($type == 'token-listrik'){
            $data = 'PLN';
        }else if ($type == 'voucher-game'){
            $data = 'GAME';
        }else{
            $data = 'PULSA';
        }

        $produk = Pulsa::detail_produk_pembelian($data);

        if($produk->result == "failed" ){
            return 'error';
        }else{
                for($z = 0; $z < $o; $z++)
                {
                    $results = array();
                    foreach($produk->message as $item){
                        if($code[$z] == $item->code){
                            $results[] = [
                                    'code'=>$item->code,
                                    'description'=>$item->description,
                                    'price_api'=>$item->price,
                                    'status'=>$item->status,
                            ];
                        }
                    }

                    if($results[0]['status'] == 'normal'){
                        $status = '1';
                    }else{
                        $status = '0';
                    }

                     DB::table('pembelianproduks')
                        ->where('product_id', $code[$z])
                        ->update([
                            'product_name' => $results[0]['description'],
                            'price_default' => $results[0]['price_api'],
                            'status' => $status,
                            ]);
                }
        }

    }

    //Update by CHECKLIST MARKUP
    public function updateHargaPerChecklistMarkup(Request $request)
    {
        $product_id = array();
        $code       = array();
        $o          = count($request->datachecked);
        for($i = 0; $i < $o; $i++){
            array_push($product_id, $request->datachecked[$i][0]['value']);
            array_push($code, $request->datachecked[$i][1]['value']);
        }

        $type = $request->input('jenis_produk');
        // return json_encode($type);
        // return json_encode([$product_id,$code]);

        for($z = 0; $z < $o; $z++){
             DB::table('pembelianproduks')
                ->where('product_id', $code[$z])
                ->update([
                    'price_markup' => '0',
                    ]);
        }

    }


    //Update by item
    public function updateHargaOtomatis(Request $request)
    {
        return;
        $id = $request->input('id');
        $type = $request->input('url_link');
        
        if($type == 'token-listrik'){
            $code = 'PLN';
        }else if ($type == 'voucher-game'){
            $code = 'GAME';
        }else{
            $code = 'PULSA';
        }

        $produk = Pulsa::detail_produk_pembelian($code);

        if($produk->result == "failed" ){
            return 'error';
        }else{
            $results = array();
            foreach($produk->message as $item){
                if($id == $item->code){
                    $results[] = [
                            'code'=>$item->code,
                            'description'=>$item->description,
                            'price_api'=>$item->price,
                            'status'=>$item->status,
                    ];
                }
            }

            if($results[0]['status'] == 'normal'){
                $status = '1';
            }else{
                $status = '0';
            }

             DB::table('pembelianproduks')
                ->where('product_id', $id)
                ->update([
                        'product_name' => $results[0]['description'],
                        'price_default' => $results[0]['price_api'],
                        'status' => $status,
                    ]);
        }

    }

    //update all data
    public function updateHargaSemua(Request $request)
    {
        return;
        $jenis = $request->input('jenis');

        if($jenis == 'harga_default'){

            //GET DATA GAME
            $data_game ='GAME';
            $produk_game = Pulsa::detail_produk_pembelian($data_game);
            //-------------------------------------------------------
            
            //GET DATA PLN
            $data_pln = 'PLN';
            $produk_pln = Pulsa::detail_produk_pembelian($data_pln);
            //----------------------------------------------------------

            //GET DATA PULSA
            $data_pulsa = 'PULSA';
            $produk_pulsa = Pulsa::detail_produk_pembelian($data_pulsa);
            //---------------------------------------------------------

            if($produk_game->result == "failed" || $produk_pln->result == "failed" || $produk_pulsa->result == "failed" ){
                return 'error';
            }else{
               $results_game = array();
                foreach($produk_game->message as $item){
                        $results_game[] = [
                                'code'=>$item->code,
                                'description'=>$item->description,
                                'price_api'=>$item->price,
                                'status'=>$item->status,
                        ];
                    
                }

                $results_pln = array();
                foreach($produk_pln->message as $item){
                        $results_pln[] = [
                                'code'=>$item->code,
                                'description'=>$item->description,
                                'price_api'=>$item->price,
                                'status'=>$item->status,
                        ];
                    
                }

                $results_pulsa = array();
                foreach($produk_pulsa->message as $item){
                        $results_pulsa[] = [
                                'code'=>$item->code,
                                'description'=>$item->description,
                                'price_api'=>$item->price,
                                'status'=>$item->status,
                        ];
                    
                }

                //update game
                for($i=0; $i<count($results_game);$i++){
                    if($results_game[$i]['status'] == 'normal'){
                        $status = '1';
                    }else{
                        $status = '0';
                    }
                 DB::table('pembelianproduks')
                    ->where('product_id', $results_game[$i]['code'])
                    ->update([
                        'product_name' => $results_game[$i]['description'],
                        'price_default' => $results_game[$i]['price_api'],
                        'status' => $status,
                        ]);
                }

                //update pln
                for($i=0; $i<count($results_pln);$i++){
                    if($results_pln[$i]['status'] == 'normal'){
                        $status = '1';
                    }else{
                        $status = '0';
                    }
                 DB::table('pembelianproduks')
                    ->where('product_id', $results_pln[$i]['code'])
                    ->update([
                        'product_name' => $results_pln[$i]['description'],
                        'price_default' => $results_pln[$i]['price_api'],
                        'status' => $status,
                        ]);
                }
                
                //update pulsa
                for($i=0; $i<count($results_pulsa);$i++){
                    if($results_pulsa[$i]['status'] == 'normal'){
                        $status = '1';
                    }else{
                        $status = '0';
                    }
                 DB::table('pembelianproduks')
                    ->where('product_id', $results_pulsa[$i]['code'])
                    ->update([
                        'product_name' => $results_pulsa[$i]['description'],
                        'price_default' => $results_pulsa[$i]['price_api'],
                        'status' => $status,
                        ]);
                }
            }
                
        }

        if($jenis == 'harga_markup'){
            DB::table('pembelianproduks')
            ->update([
                'price_markup' => '0'
                ]);
        }

    }


    //update data by kategori
    public function updateHaragSumMakupPerKategori(Request $request)
    {
        $id_kategori = $request->input('id_kategori');
        $aksi        = $request->input('aksi');
        $nominal     =str_replace('.','',  $request->input('nominal'));
        Pembelianproduk::updateAllpriceByCategory($id_kategori,$aksi,$nominal);

    }

    //update data by operator
    public function updateHaragSumMakupPerOperator(Request $request)
    {
        $id_operator = $request->input('id_operator');
        $aksi        = $request->input('aksi');
        $nominal     =str_replace('.','',  $request->input('nominal'));
        $getIdOp = Pembelianproduk::getIdOperator($id_operator)->first();
        Pembelianproduk::updateAllpriceByOperator($getIdOp->id,$aksi,$nominal);

    }


    //update data by kategori
    public function updateHargaPerKategori(Request $request)
    {
        return;
        $jenis       = $request->input('jenis');
        $id_kategori = $request->input('id_kategori');

        if($jenis == 'harga_default'){

            if($id_kategori == 1)
            {
                $jenis = 'REGULER';
                $data = 'PULSA';
            }else if($id_kategori == 2)
            {
                $jenis = 'INTERNET';
                $data = 'PULSA';
            }else if($id_kategori == 3)
            {   
                $jenis = 'GAME';
                $data =  'GAME';
            }else if($id_kategori == 4)
            {    
                $jenis = 'PLN';
                $data = 'PLN';
            }else if($id_kategori == 5)
            {    
                $jenis = 'LAIN';
                $data = 'PULSA';
            }

            $produk = Pulsa::detail_produk_pembelian($data);
            if($produk->result == "failed"){
                return 'error';
            }else{
               $results = array();
                foreach($produk->message as $item){
                    if($id_kategori == 3){
                        if($jenis == $item->provider){
                            $results[] = [
                                    'code'=>$item->code,
                                    'description'=>$item->description,
                                    'price_api'=>$item->price,
                                    'status'=>$item->status
                            ];
                        }
                    }else{
                        if($jenis == $item->provider_sub){
                            $results[] = [
                                    'code'=>$item->code,
                                    'description'=>$item->description,
                                    'price_api'=>$item->price,
                                    'status'=>$item->status
                            ];
                        }
                    }
                    
                }

                for($i=0; $i<count($results);$i++){
                    if($results[$i]['status'] == 'normal'){
                        $status = '1';
                    }else{
                        $status = '0';
                    }

                     DB::table('pembelianproduks')
                        ->where('product_id', $results[$i]['code'])
                        ->update([
                            'product_name' => $results[$i]['description'],
                            'price_default' => $results[$i]['price_api'],
                            'status' => $status,
                            ]);
                }
                
            }
        }

        if($jenis == 'harga_markup'){
            DB::table('pembelianproduks')
            ->where('pembeliankategori_id', $id_kategori)
            ->update([
                'price_markup' => '0',
                ]);
        }

    }


    //update data by operator
    public function updateHargaPerOperator(Request $request)
    {
        return;
        $id_kategori = $request->input('id_kategori');
        $id_operator = $request->input('id_operator');
        $jenis       = $request->input('jenis');

        if($jenis == 'harga_default'){
            // $getProductIdOperator = Pembelianproduk::getProductIdOperator($id_operator)->first();

            if($id_kategori == 1)
            {
                $data = 'PULSA';
            }else if($id_kategori == 2)
            {
                $data = 'PULSA';
            }else if($id_kategori == 3)
            {   
                $data =  'GAME';
            }else if($id_kategori == 4)
            {    
                $data = 'PLN';
            }else if($id_kategori == 5)
            {    
                $data = 'PULSA';
            }

            $produk = Pulsa::detail_produk_pembelian($data);
            if($produk->result == "failed"){
                return 'error';
            }else{
               $results = array();
                foreach($produk->message as $item){
                    if($id_operator == $item->operator_sub){
                        $results[] = [
                                'code'=>$item->code,
                                'description'=>$item->description,
                                'price_api'=>$item->price,
                                'status'=>$item->status
                        ];
                    }
                }

                for($i=0; $i<count($results);$i++){
                    if($results[$i]['status'] == 'normal'){
                        $status = '1';
                    }else{
                        $status = '0';
                    }

                     DB::table('pembelianproduks')
                        ->where('product_id', $results[$i]['code'])
                        ->update([
                            'product_name' => $results[$i]['description'],
                            'price_default' => $results[$i]['price_api'],
                            'status' => $status,
                            ]);
                }
                
            }
        }

        if($jenis == 'harga_markup'){ 
            $getData = Pembelianproduk::getIdOperator($id_operator)->first();
            DB::table('pembelianproduks')
            ->where('pembelianoperator_id', $getData->id)
            ->update([
                'price_markup' => '0',
                ]);
        }

    }

    public function showbyKategori($title)
    {
        $kategori = Pembeliankategori::where('slug', $title)->first();
        $operator = Pembelianoperator::where('id', $kategori->pembelianoperator->first()->id)->first();

        $kategori_all = Pembelianproduk::getAllKategori();
        return view('admin.pembelian.produk.show', compact('kategori','operator','kategori_all'));
    }

    public function findproduct(Request $request)
    {
        // $operator = Pembelianoperator::where('pembeliankategori_id', $request->kategori_id)->get();
        // dd($operator);

        $query = Pembelianproduk::getOperatorWhere($request->kategori_id);

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

    public function importAllData(Request $request)
    {   
        $aksi    = $request->input('aksi');
        $nominal = str_replace('.','',  $request->input('nominal'));

        Pembelianproduk::updateAllprice($aksi,$nominal);

    }


    public function deleteAllProduk(Request $request)
    {
        $produk = Pembelianproduk::truncate();
        return Response::json($produk);
    }

    public function edit($jenis,$id)
    {
        return;
        $produks  = Pembelianproduk::where('id',$id)->first();
        $operator = Pembelianoperator::where('id', $produks->pembelianoperator_id)->first();
        $kategori = Pembeliankategori::where('id', $operator->pembeliankategori_id)->first();
        $code     = $kategori->type;
        
        //$produk = Pulsa::detail_produk_pembelian($code);
        $produk = DigiFlazz::EditProdukPrabayar($code);
        $produk = json_decode($produk);
        if($produk->result == "failed" ){
            return 'Api tidak terhubung';
        }else{
            $produk = $produk->response->data;
            
            if($produk->buyer_product_status == true || $produk->seller_product_status == true){
                $status = 1;
            }else{
                $status = 0;
            }
            $results = array();
            foreach($produk as $item){
                if($item->code == $produks->product_id){
                    $results[] = [
                            'id'=>$item->id,
                            'code'=>$item->buyer_sku_code,
                            'description'=>$item->desc,
                            'operator'=>$item->brand,
                            'price_api'=>$item->price,
                            'status'=>$status,
                    ];
                }
            }

            return view('admin.pembelian.produk.edit', compact('produks','results','operator'));
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'price_jual' => 'required',
        ],[
            'price_jual.required' => 'Harga Jual tidak boleh kosong',
        ]);
        $produks = Pembelianproduk::findOrFail($id);
        // $produks->price = $request->price;
        $produks->price_markup = str_replace('.','', $request->price_markup);
        $produks->save();
        return redirect()->back()->with('alert-success', 'Berhasil Merubah Data Produk');
    }
}