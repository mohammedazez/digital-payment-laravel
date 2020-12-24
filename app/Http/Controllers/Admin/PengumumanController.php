<?php

namespace App\Http\Controllers\Admin;

use App\AppModel\Pengumuman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PengumumanController extends Controller
{
    public function index()
    {
        $p = Pengumuman::findOrFail(1);
        return view('admin.pengaturan.pengumuman', compact('p'));
    }
    
    public function store(Request $request)
    {
        $content = htmlentities($request->input('content'), ENT_QUOTES);
        
        $update = Pengumuman::where('id', '1')
                    ->update([
                        'content'   => $content,
                        'link'      => $request->link,
                        ]);
                        
        if( $update )
        {
            return redirect()->back()->with('alert-success', 'Pengumuman berhasil disimpan');
        }
        
        return redirect()->back()->with('alert-error', 'Pengumuman GAGAL disimpan');
    }
}