<?php

namespace App\Http\Controllers\Admin;

use App\AppModel\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingSecurityController extends Controller
{
    public function index()
    {
    	$settings = Setting::firstOrFail();
    	return view('admin.pengaturan.keamanan', compact('settings'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'force_verification' => 'required|numeric',
            'prevent_multilogin' => 'required|numeric',
            'max_daily_deposit_personal' => 'required|numeric',
            'max_daily_deposit_agen' => 'required|numeric',
            'max_daily_deposit_enterprise' => 'required|numeric',
        ],[
            'force_verification.required' => 'Verification tidak boleh kosong',
            'force_verification.numeric' => 'Verification tidak valid',
            'prevent_multilogin.required' => 'Multilogin tidak boleh kosong',
            'prevent_multilogin.numeric' => 'Multilogin tidak valid',
            'max_daily_deposit_personal.required' => 'Batas deposit tidak boleh kosong',
            'max_daily_deposit_personal.numeric' => 'Batas deposit tidak valid',
            'max_daily_deposit_agen.required' => 'Batas deposit tidak boleh kosong',
            'max_daily_deposit_agen.numeric' => 'Batas deposit tidak valid',
            'max_daily_deposit_enterprise.required' => 'Batas deposit tidak boleh kosong',
            'max_daily_deposit_enterprise.numeric' => 'Batas deposit tidak valid',
        ]);

        $settings = Setting::first();
        $settings->force_verification = (int) $request->force_verification;
        $settings->prevent_multilogin = (int) $request->prevent_multilogin;
        $settings->max_daily_deposit_personal = (int) $request->max_daily_deposit_personal;
        $settings->max_daily_deposit_agen = (int) $request->max_daily_deposit_agen;
        $settings->max_daily_deposit_enterprise = (int) $request->max_daily_deposit_enterprise;
        $settings->save();
        return redirect()->back()->with('alert-success', 'Berhasil Melakukan Perubahan Pengaturan Keamanan');
    }
}