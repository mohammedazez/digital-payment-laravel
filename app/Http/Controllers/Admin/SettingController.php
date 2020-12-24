<?php

namespace App\Http\Controllers\Admin;

use Pulsa;
use App\AppModel\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function cekapikey($apikey)
    {
        return false;
    }
    
    public function indexSetting()
    {
    	$settings = Setting::first();
    	return view('admin.pengaturan.sistem.index', compact('settings'));
    }
    
    public function storeSetting(Request $request, $id)
    {
            $this->validate($request,[
                'nama_sistem' => 'required',
                'motto' => 'required',
                'description' => 'required',
                'pemilik' => 'required',
                'alamat' => 'required',
                'email' => 'required|email',
                'hotline' => 'required',
                'website' => 'required',
                'facebook_url' => 'nullable|url',
                'twitter_url' => 'nullable|url',
                'instagram_url' => 'nullable|url',
                'youtube_url'   => 'nullable|url',
            ],[
                'nama_sistem.required' => 'Nama Sistem tidak boleh kosong',
                'motto.required' => 'Motto tidak boleh kosong',
                'description.required' => 'Deskripsi tidak boleh kosong',
                'pemilik.required' => 'Pemilik tidak boleh kosong',
                'alamat.required' => 'Alamat Kantor/Usaha tidak boleh kosong',
                'email.required' => 'Email Kontak tidak boleh kosong',
                'email.email' => 'Email Kontak harus berformat email',
                'hotline.required' => 'Hotline/Nomor HAndphone tidak boleh kosong',
                'website.required' => 'Website tidak boleh kosong',
                'facebook_url.url' => 'Facebook URL tidak valid. Masukkan URL lengkap dengan http/https',
                'twitter_url.url' => 'Twitter URL tidak valid. Masukkan URL lengkap dengan http/https',
                'instagram_url.url' => 'Instagram URL tidak valid. Masukkan URL lengkap dengan http/https',
                'youtube_url.url'=>'Youtube URL tidak valid. Masukkan URL lengkap dengan http/https',
            ]);

            $settings = Setting::findOrFail($id);
            $settings->nama_sistem = $request->nama_sistem;
            $settings->motto = $request->motto;
            $settings->description = $request->description;
            $settings->pemilik = $request->pemilik;
            $settings->alamat = $request->alamat;
            $settings->email = $request->email;
            $settings->hotline = $request->hotline;
            $settings->website = $request->website;
            $settings->facebook_url = $request->facebook_url;
            $settings->twitter_url = $request->twitter_url;
            $settings->instagram_url = $request->instagram_url;
            $settings->youtube_url  = $request->youtube_url;
            $settings->save();
            return redirect()->back()->with('alert-success', 'Berhasil Melakukan Perubahan Data Sistem');
    	
    }
}