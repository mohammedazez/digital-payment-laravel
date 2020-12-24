<?php

namespace App\Http\Controllers\Admin;

use App\AppModel\Pembayaranoperator;
use App\AppModel\Pembayarankategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PembayaranoperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operator = Pembayaranoperator::paginate(20);
        return view('admin.pembayaran.operator.index', compact('operator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Pembayarankategori::all();
        $operator = Pembayaranoperator::all();
        return view('admin.pembayaran.operator.create', compact('kategori', 'operator'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'kategori' => 'required',
            'product_name' => 'required',
        ],[
            'kategori.required' => 'Kategori Pembayaran tidak boleh kosong',
            'product_name.required' => 'Nama Kategori Pembayaran tidak boleh kosong',
        ]);
        $operator = new Pembayaranoperator();
        $operator->pembayarankategori_id = $request->kategori;
        $operator->product_name = $request->product_name;
        $operator->status = $request->status;
        $operator->save();
        return redirect()->back()->with('alert-success', 'Berhasil Menambah Operator Pembayaran');
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
        $operator = Pembayaranoperator::findOrFail($id);
        $kategori = Pembayarankategori::all();
        $operators = Pembayaranoperator::all();
        return view('admin.pembayaran.operator.edit', compact('operator', 'kategori', 'operators'));
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
        $this->validate($request,[
            'kategori' => 'required',
            'product_name' => 'required',
        ],[
            'kategori.required' => 'Kategori Pembayaran tidak boleh kosong',
            'product_name.required' => 'Nama Kategori Pembayaran tidak boleh kosong',
        ]);
        $operator = Pembayaranoperator::findOrFail($id);
        $operator->pembayarankategori_id = $request->kategori;
        $operator->product_name = $request->product_name;
        $operator->status = $request->status;
        $operator->save();
        return redirect()->route('pembayaran-operator.index')->with('alert-success', 'Berhasil Mengubah Operator Pembayaran');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $operator = Pembayaranoperator::findOrFail($id);
        $operator->pembayaranproduk()->delete();
        $operator->delete();
        return redirect()->back()->with('alert-success', 'Berhasil Menghapus Operator Pembayaran');
    }
}