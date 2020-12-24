<?php

namespace App\Http\Controllers\Admin;

use App\AppModel\Pembayarankategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Input as Input;
use Illuminate\Support\Str;
use File;


class PembayarankategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Pembayarankategori::orderBy('sort_product', 'ASC')->paginate(20);
        
        return view('admin.pembayaran.kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Pembayarankategori::paginate(10);
        return view('admin.pembayaran.kategori.create', compact('kategori'));
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
            'product_name' => 'required',
            'icon' => 'required',
            'icon'      => 'required|image|mimes:jpeg,png,jpg',
            'icon'      => 'required|image|mimes:jpeg,png,jpg|max:1536',
        ],[
            'product_name.required' => 'Nama Kategori tidak boleh kosong',
            'icon.required' => 'Icon Kategori tidak boleh kosong',
            'icon.image'         => 'Icon harus berformat gambar',
            'icon.max'           => 'Icon Max Size 1,5MB'
        ]);
        $kategori = new Pembayarankategori();

        $imageIcon = $request->file('icon');

        $nameImage = Str::random(10).'.'.$imageIcon->getClientOriginalExtension();
        $imageIcon->move('assets/images/icon_web', $nameImage);

        $kategori->product_name = $request->product_name;
        $kategori->slug = str_slug($request->product_name, '-');
        $kategori->icon = $nameImage;
        $kategori->status = $request->status;
        $kategori->save();
        return redirect()->back()->with('alert-success', 'Berhasil Menambah Kategori Pembayaran');
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
        $kategori = Pembayarankategori::findOrFail($id);
        $kategoris = Pembayarankategori::paginate(10);
        return view('admin.pembayaran.kategori.edit', compact('kategori', 'kategoris'));
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
            'product_name' => 'required',
            'icon'      => 'image|mimes:jpeg,png,jpg',
            'icon'      => 'image|mimes:jpeg,png,jpg|max:1536',
        ],[
            'product_name.required' => 'Nama Kategori tidak boleh kosong',
            'icon.image'         => 'Icon harus berformat gambar',
            'icon.max'           => 'Icon Max Size 1,5MB'
        ]);
        
        $kategori = Pembayarankategori::findOrFail($id);
        
        $kategori->sort_product = intval($request->sort_product);
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
        return redirect()->route('pembayaran-kategori.index')->with('alert-success', 'Berhasil Mengubah Kategori Pembayaran');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = Pembayarankategori::findOrFail($id);
        $kategori->pembayaranproduk()->delete();
        $kategori->pembayaranoperator()->delete();
        $kategori->delete();
        return redirect()->back()->with('alert-success', 'Berhasil Menghapus Kategori Pembayaran');
    }
}