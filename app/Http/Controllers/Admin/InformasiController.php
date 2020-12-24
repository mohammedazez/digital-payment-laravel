<?php

namespace App\Http\Controllers\Admin;

use Auth, Notif;
use App\AppModel\Informasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Informasi::orderBy('created_at', 'DESC')->get();
        return view('admin.pengaturan.pusat-informasi.index', compact('info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pengaturan.pusat-informasi.create');
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
            'title' => 'required',
            'isi_informasi' => 'required',
        ],[
            'title.required' => 'Title tidak boleh kosong',
            'isi_informasi.required' => 'Isi Informasi tidak boleh kosong',
        ]);
        $info = new Informasi();
        $info->title = $request->title;
        $info->type = $request->type;
        $info->isi_informasi = $request->isi_informasi;
        $info->user_id = Auth::user()->id;
        $info->save();
        
        // $title = $request->title;
        // $body = strip_tags(substr($request->isi_informasi, 0, 50)) ;
        // $notif = Notif::alluser($title, $body);
                                
        return redirect()->route('pusat-informasi.index')->with('alert-success', 'Berhasil Menambah Informasi');
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
        $info = Informasi::findOrFail($id);
        return view('admin.pengaturan.pusat-informasi.edit', compact('info'));
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
            'title' => 'required',
            'isi_informasi' => 'required',
        ],[
            'title.required' => 'Title tidak boleh kosong',
            'isi_informasi.required' => 'Isi Informasi tidak boleh kosong',
        ]);
        $info = Informasi::findOrFail($id);
        $info->title = $request->title;
        $info->type = $request->type;
        $info->isi_informasi = $request->isi_informasi;
        $info->user_id = Auth::user()->id;
        $info->save();
        
        $title = $request->title;
        $body = strip_tags(substr($request->isi_informasi, 0, 50)) ;
        $notif = Notif::alluser($title, $body);
        return redirect()->route('pusat-informasi.index')->with('alert-success', 'Berhasil Merubah Informasi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $info = Informasi::findOrFail($id);
        $info->delete();
        return redirect()->route('pusat-informasi.index')->with('alert-success', 'Berhasil Menghapus Informasi');
    }
}