<?php

namespace App\Http\Controllers\Admin;

use App\AppModel\Tos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tos = Tos::paginate(10);
        return view('admin.pengaturan.tos.index', compact('tos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pengaturan.tos.create');
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
            'content' => 'required',
        ], [
            'title.required' => 'Title/Judul Point tidak boleh kosong',
            'content.required' => 'Isi TOS/Content tidak boleh kosong',
        ]);
        $tos = new Tos();
        $tos->title = $request->title;
        $tos->slug = str_slug($request->title, '-');
        $tos->content = $request->content;
        $tos->save();
        return redirect()->route('tos.index')->with('alert-success', 'Berhasil Menambah Poin TOS');

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
        $tos = Tos::findOrFail($id);
        return view('admin.pengaturan.tos.edit', compact('tos'));
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
            'content' => 'required',
        ], [
            'title.required' => 'Title/Judul Point tidak boleh kosong',
            'content.required' => 'Isi TOS/Content tidak boleh kosong',
        ]);
        $tos = Tos::findOrFail($id);
        $tos->title = $request->title;
        $tos->slug = str_slug($request->title, '-');
        $tos->content = $request->content;
        $tos->save();
        return redirect()->route('tos.index')->with('alert-success', 'Berhasil Mengubah Poin TOS');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tos = Tos::findOrFail($id);
        $tos->delete();
        return redirect()->route('tos.index')->with('alert-success', 'Berhasil Menghapus Poin TOS');
    }
}