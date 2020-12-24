<?php

namespace App\Http\Controllers\Admin;

use App\AppModel\Pembeliankategori;
use App\AppModel\Pembelianoperator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PembelianoperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operators = Pembelianoperator::get();
        return view('admin.pembelian.operator.index', compact('operators'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategoris = Pembeliankategori::all();
        $operators = Pembelianoperator::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.pembelian.operator.create', compact('kategoris', 'operators'));
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
            'product_id' => 'required',
            'product_name' => 'required',
            'kategori' => 'required',
        ],[
            'product_id.required' => 'ID Operator Server tidak boleh kosong.',
            'product_name.required' => 'Nama Operator tidak boleh kosong.',
            'kategori.required' => 'Kategori tidak boleh kosong.',
        ]);
        $operators = new Pembelianoperator();
        $operators->product_id = $request->product_id;
        $operators->product_name = $request->product_name;
        if (!empty($request->prefix)) {
            $operators->prefix = $request->prefix;
        }
        if (!empty($request->img_url)) {
            $operators->img_url = $request->img_url;
        }
        $operators->pembeliankategori_id = $request->kategori;
        $operators->status = $request->status;
        $operators->save();
        return redirect()->back()->with('alert-success', 'Berhasil Menambah Operator Produk');
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
    public function edit($id)
    {
        $operators = Pembelianoperator::findOrFail($id);
        $kategoris = Pembeliankategori::all();
        $operatorsall = Pembelianoperator::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.pembelian.operator.edit', compact('kategoris', 'operators', 'operatorsall'));
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
            'product_id' => 'required',
            'product_name' => 'required',
            'kategori' => 'required',
        ],[
            'product_id.required' => 'ID Operator Server tidak boleh kosong.',
            'product_name.required' => 'Nama Operator tidak boleh kosong.',
            'kategori.required' => 'Kategori tidak boleh kosong.',
        ]);
        $operators = Pembelianoperator::findOrFail($id);
        $operators->product_id = $request->product_id;
        $operators->product_name = $request->product_name;
        if (!empty($request->prefix)) {
            $operators->prefix = $request->prefix;
        }
        if (!empty($request->img_url)) {
            $operators->img_url = $request->img_url;
        }
        $operators->pembeliankategori_id = $request->kategori;
        $operators->status = $request->status;
        $operators->save();
        return redirect()->route('pembelian-operator.index')->with('alert-success', 'Berhasil Mengubah Operator Produk');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $operators = Pembelianoperator::findOrFail($id);
        $operators->pembelianproduk()->delete();
        $operators->delete();
        return redirect()->back()->with('alert-success', 'Berhasil Menghapus Operator Produk');
    }
}