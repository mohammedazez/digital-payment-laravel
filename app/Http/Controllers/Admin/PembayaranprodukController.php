<?php

namespace App\Http\Controllers\Admin;

use Pulsa, Response,DigiFlazz;
use App\AppModel\Pembayaranproduk;
use App\AppModel\Pembayaranoperator;
use App\AppModel\Pembayarankategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PembayaranprodukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produks = Pembayaranproduk::get();
        $kategoriMD = Pembayarankategori::all();
        return view('admin.pembayaran.produk.index', compact('produks','kategoriMD'));
    }

    public function showbyKategori($title)
    {
        // dd($title);
        $kategori = Pembayarankategori::where('slug', $title)->first();
        // $operator = Pembayaranoperator::where('id', $kategori->pembayaranoperator->first()->id)->first();
        $operator = Pembayaranoperator::where('pembayarankategori_id', $kategori->id)->first();

        $kategori_all = Pembayaranproduk::getAllKategori();
        return view('admin.pembayaran.produk.show', compact('kategori','operator','kategori_all'));
    }

    public function findproduct(Request $request)
    {
        // $operator = Pembelianoperator::where('pembeliankategori_id', $request->kategori_id)->get();
        // dd($operator);

         $query = Pembayaranproduk::getOperatorWhere($request->kategori_id);

        return Response::json($query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($title)
    {
        $kategori = Pembayarankategori::where('slug', $title)->first();
        $operator = Pembayaranoperator::where('pembayarankategori_id', $kategori->id)->get();
        $produk = Pembayaranproduk::where('pembayarankategori_id', $kategori->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.pembayaran.produk.create', compact('operator', 'kategori', 'produk'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'operator' => 'required',
            'product_name' => 'required',
            'code' => 'required',
            'price_default' => 'required',
            'markup' => 'required'
        ],[
            'operator.required' => 'Operator Produk tidak boleh kosong',
            'product_name.required' => 'Nama Produk tidak boleh kosong',
            'code.required' => 'Kode Produk tidak boleh kosong',
            'price_default.required' => 'Biaya default tidak boleh kosong',
            'markup.required' => 'Markup biaya tidak boleh kosong',
        ]);

        $produk = new Pembayaranproduk();
        $produk->pembayaranoperator_id = $request->operator;
        $produk->pembayarankategori_id = $request->kategori;
        $produk->product_name = $request->product_name;
        $produk->code = $request->code;
        $produk->price_default = str_replace('.', '', $request->price_default);
        $produk->markup = str_replace('.', '', $request->markup);
        $produk->price_markup = ($produk->price_default + $produk->markup);
        $produk->status = $request->status;
        $produk->save();
        return redirect()->back()->with('alert-success', 'Berhasil Menambah Produk Pembayaran');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($title, $id)
    {
        $kategori = Pembayarankategori::where('slug', $title)->first();
        $operator = Pembayaranoperator::where('pembayarankategori_id', $kategori->id)->get();
        $produks = Pembayaranproduk::where('pembayarankategori_id', $kategori->id)->orderBy('created_at', 'DESC')->paginate(10);
        $produk = Pembayaranproduk::findOrFail($id);
        return view('admin.pembayaran.produk.edit', compact('operator', 'kategori', 'produks', 'produk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'operator' => 'required',
            'product_name' => 'required',
            'code' => 'required',
            'markup' => 'required',
        ],[
            'operator.required' => 'Operator Produk tidak boleh kosong',
            'product_name.required' => 'Nama Produk tidak boleh kosong',
            'code.required' => 'Kode Produk tidak boleh kosong',
            'markup.required' => 'Markup biaya admin tidak boleh kosong',
        ]);
        $produk = Pembayaranproduk::findOrFail($id);
        $produk->pembayaranoperator_id = $request->operator;
        $produk->pembayarankategori_id = $request->kategori;
        $produk->product_name = $request->product_name;
        $produk->code = $request->code;
        $produk->markup = str_replace('.', '', $request->markup);
        $produk->price_markup = ($produk->price_default + $produk->markup);
        $produk->status = $request->status;
        $produk->save();
        return redirect()->to('/admin/pembayaran-produk/'.$request->kategori_slug.'')->with('alert-success', 'Berhasil Merubah Produk Pembayaran');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletePembelian = Pembayaranproduk::where('id', $id)
                            ->delete();
                            
        return redirect()->route('admin.pembayaranProduk.index')->with('alert-success', 'Berhasil Menghapus Data Produk');
    }

    //update all data
    public function updateHargaSemua()
    {
        try{
            DB::table('pembayaranproduks')
            ->update([
                'markup' => 0
                ]);

        } catch (Exception $e) {
            dd($e);
        }
    }

    //update data by kategori
    public function updateHargaPerKategori(Request $request)
    {
        $id_kategori = $request->input('id_kategori');
        // dd($id_kategori);
        try{
            DB::table('pembayaranproduks')
            ->where('pembayarankategori_id', $id_kategori)
            ->update([
                'markup' => 0,
                ]);
        } catch (Exception $e) {
            dd($e);
        }

    }

    //update data by operator
    public function updateHargaPerOperator(Request $request)
    {
        $id_kategori = $request->input('id_kategori');
        $id_operator = $request->input('id_operator');
        try{
            DB::table('pembayaranproduks')
            ->where('pembayaranoperator_id', $id_operator)
            ->update([
                'markup' => 0,
                ]);

        } catch (Exception $e) {
            dd($e);
        }
    }
    public function import(Request $request)
    {

        $aksi = $request->input('aksi');
        $nominal = $request->input('nominal');
        $type = $request->input('type');

        Pembayaranproduk::updateAllpriceByCategory($type,$aksi,$nominal);

    }

    public function importAllData(Request $request)
    {
        $aksi = $request->input('aksi');
        $nominal =str_replace('.','',  $request->input('nominal'));
        try{
            Pembayaranproduk::updateAllprice($aksi,$nominal);
        } catch (Exception $e) {
            dd($e);
        }

    }

    //update data by kategori
    public function updateHaragSumMakupPerKategori(Request $request)
    {
        $id_kategori = $request->input('id_kategori');
        $aksi = $request->input('aksi');
        $nominal =str_replace('.','',  $request->input('nominal'));
        try{
            Pembayaranproduk::updateAllpriceByCategory($id_kategori,$aksi,$nominal);
        } catch (Exception $e) {
            dd($e);
        }

    }

    //update data by operator
    public function updateHaragSumMakupPerOperator(Request $request)
    {
        $id_operator = $request->input('id_operator');
        $aksi = $request->input('aksi');
        $nominal =str_replace('.','',  $request->input('nominal'));
        try{
            Pembayaranproduk::updateAllpriceByOperator($id_operator,$aksi,$nominal);
        } catch (Exception $e) {
            dd($e);
        }

    }


        //Update by CHECKLIST
    public function updateHargaPerChecklist(Request $request)
    {
        $id   = array();
        $code = array();
        $o    = count($request->datachecked);
        for($i = 0; $i < $o; $i++){
            array_push($id, $request->datachecked[$i][0]['value']);
            array_push($code, $request->datachecked[$i][1]['value']);
        }

        $type = $request->input('jenis_produk');

        try{
            for($z = 0; $z < $o; $z++){
                 DB::table('pembayaranproduks')
                    ->where('id', $id[$z])
                    ->update([
                        'markup' => 0
                        ]);
            }
        } catch (Exception $e) {
            dd($e);
        }

    }

}
