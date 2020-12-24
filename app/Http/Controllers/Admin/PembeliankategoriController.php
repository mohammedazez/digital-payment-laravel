<?php

namespace App\Http\Controllers\Admin;

use Pulsa;
use App\AppModel\Pembeliankategori;
use App\AppModel\Pembelianproduk;
use App\AppModel\Pembelianoperator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Input as Input;
use Illuminate\Support\Str;
use File;

class PembeliankategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategoris = Pembeliankategori::orderBy('sort_product', 'ASC')->get();
        return view('admin.pembelian.kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori_server = Pulsa::kategori_pembelian();
        return view('admin.pembelian.kategori.create', compact('kategori_server'));
        
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
            'icon' => 'required',
            'icon'      => 'required|image|mimes:jpeg,png,jpg',
            'icon'      => 'required|image|mimes:jpeg,png,jpg|max:1536',
        ],[
            'product_id.required' => 'ID Kategori (Server) tidak boleh kosong',
            'product_name.required' => 'Nama Kategori tidak boleh kosong',
            'icon.required' => 'Icon Kategori tidak boleh kosong',
            'icon.image'         => 'Icon harus berformat gambar',
            'icon.max'           => 'Icon Max Size 1,5MB'
        ]);

        $kategori = new Pembeliankategori();

        $imageIcon = $request->file('icon');

        $nameImage = Str::random(10).'.'.$imageIcon->getClientOriginalExtension();
        $imageIcon->move('assets/images/icon_web', $nameImage);

        $kategori->product_id = $request->product_id;
        $kategori->product_name = $request->product_name;
        $kategori->icon = $nameImage;
        $kategori->slug = str_slug($request->product_name, '-');
        $kategori->status = $request->status;
        $kategori->save();
        return redirect()->back()->with('alert-success', 'Berhasil Menambah Kategori Produk');
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
        $kategori = Pembeliankategori::findOrFail($id);
        //$kategori_server = Pulsa::kategori_pembelian();
        
        return view('admin.pembelian.kategori.edit', compact('kategori'));
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
            'icon'      => 'image|mimes:jpeg,png,jpg',
            'icon'      => 'image|mimes:jpeg,png,jpg|max:1536',
        ],[
            'product_id.required' => 'ID Kategori (Server) tidak boleh kosong',
            'product_name.required' => 'Nama Kategori tidak boleh kosong',
            'icon.image'         => 'Icon harus berformat gambar',
            'icon.max'           => 'Icon Max Size 1,5MB'
        ]);

        $kategori = Pembeliankategori::findOrFail($id);
        
        $kategori->sort_product = intval($request->sort_product);
        $kategori->product_id = $request->product_id;
        $kategori->product_name = $request->product_name;
        $kategori->slug = str_slug($request->product_name, '-');
        $kategori->status = $request->status;

        if($request->file('icon')){
            $icon = $request->file('icon');
            $target = 'assets/images/icon_web/'.$kategori->icon;
            if(file_exists($target)){
                File::delete('assets/images/icon_web/'.$kategori->icon);
            }
            $image = Str::random(10).'.'.$icon->getClientOriginalExtension();
            $icon->move('assets/images/icon_web',$image);

            $kategori->icon = $image;
            $kategori->save();
        }

        if( $request->hasFile('image') )
        {
            $file = $request->file('image');
            $target = 'assets/images/icon_web/'.$kategori->icon;
            if( file_exists($target) && is_file($target) ){
                unlink($target);
            }

            $fileName   = 'icon-'.str_slug($request->icon, '-').'.png';
            $file->move("assets/images/icon_web/", $fileName);
            $kategori->icon = $fileName;
        }

        $kategori->save();

        return redirect()->route('pembelian-kategori.index')->with('alert-success', 'Berhasil Merubah Kategori Produk');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = Pembeliankategori::findOrFail($id);
        $operators = Pembelianoperator::where('pembeliankategori_id',$kategori->id)->get();
        $produks = Pembelianproduk::where('pembeliankategori_id',$kategori->id)->get();
        
        foreach($operators as $operator){
            $operator->delete();
        }
        foreach($produks as $produk){
            $produk->delete();
        }
        //dd($kategori);
        //$kategori->pembelianoperator->pembelianproduk()->delete();
        //$kategori->pembelianoperator()->delete();
        $kategori->delete();
        return redirect()->route('pembelian-kategori.index')->with('alert-success', 'Berhasil Menghapus Kategori Produk');
    }
}