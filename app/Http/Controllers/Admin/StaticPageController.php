<?php

namespace App\Http\Controllers\Admin;

use App\AppModel\StaticPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaticPageController extends Controller
{
    public function edit(Request $request, $slug)
    {
        $page = StaticPage::where('slug', $slug)->firstOrFail();
        
        return view('admin.static-page', compact('page'));
    }

    public function store(Request $request, $slug)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string'
            ]);
            
        $page = StaticPage::where('slug', $slug)->firstOrFail();
        $page->title = $request->title;
        $page->content = htmlentities(nl2br($request->content), ENT_QUOTES);
        $page->save();
        
        return redirect()->back()->with('alert-success', 'Berhasil memperbarui konten halaman');
    }
}