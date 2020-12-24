<?php

namespace App\Http\Controllers\Admin;

use App\AppModel\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Faq::paginate(10);
        return view('admin.pengaturan.faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pengaturan.faq.create');
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
            'pertanyaan' => 'required',
            'jawaban' => 'required',
        ],[
            'pertanyaan.required' => 'Pertanyaan tidak boleh kosong',
            'jawaban.required' => 'Jawaban tidak boleh kosong',
        ]);
        $faqs = new Faq();
        $faqs->pertanyaan = $request->pertanyaan;
        $faqs->jawaban = $request->jawaban;
        $faqs->save();
        return redirect()->route('faqs.index')->with('alert-success', 'Berhasil Menambah Data FAQ');
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
        $faqs = Faq::findOrFail($id);
        return view('admin.pengaturan.faq.edit', compact('faqs'));
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
            'pertanyaan' => 'required',
            'jawaban' => 'required',
        ],[
            'pertanyaan.required' => 'Pertanyaan tidak boleh kosong',
            'jawaban.required' => 'Jawaban tidak boleh kosong',
        ]);
        $faqs = Faq::findOrFail($id);
        $faqs->pertanyaan = $request->pertanyaan;
        $faqs->jawaban = $request->jawaban;
        $faqs->save();
        return redirect()->route('faqs.index')->with('alert-success', 'Berhasil Merubah Data FAQ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faqs = Faq::findOrFail($id);
        $faqs->delete();
        return redirect()->route('faqs.index')->with('alert-success', 'Berhasil Menghapus Data FAQ');
    }
}