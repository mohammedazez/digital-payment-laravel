<?php

namespace App\Http\Controllers\Admin;

use App\AppModel\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.pengaturan.testimonial.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $testimonials = Testimonial::findOrFail($id);
        return view('admin.pengaturan.testimonial.show', compact('testimonials'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $testimonials = Testimonial::findOrFail($id);
        if($testimonials->status == 1){ // non aktifkan
            $testimonials->status = 0;
        }else{ // aktifkan
            $testimonials->status = 1;
        }
        $testimonials->save();
        return redirect()->back()->with('alert-success', 'Berhasil Merubah Status Data Testimonial');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonials = Testimonial::findOrFail($id);
        $testimonials->delete();
        return redirect()->route('testimonial.index')->with('alert-success', 'Berhasil Menghapus Data Testimonial');
    }
}