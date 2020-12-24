<?php

namespace App\Http\Controllers\Admin;

use DB, Exception;
use App\Http\Controllers\Controller;
use App\AppModel\SettingOvoTransfer;
use Illuminate\Http\Request;

class SettingOvoTransferController extends Controller
{
    public function index(Request $request)
    {
        $setting = SettingOvoTransfer::first();
        
        return view('admin.pengaturan.ovo-transfer', compact('setting'));
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'active' => 'required',
            'phone' => 'required',
            'min_amount' => 'required',
            'max_amount' => 'required'
            ]);
            
        $setting = SettingOvoTransfer::firstOrFail();
        $setting->active = (int) $request->active;
        $setting->phone = preg_replace('/[^0-9]/', '', $request->phone);
        $setting->min_amount = intval(str_replace('.', '', $request->min_amount));
        $setting->max_amount = intval(str_replace('.', '', $request->max_amount));
        $setting->save();
        
        return redirect()->back()->with('alert-success', 'Pengaturan berhasil disimpan');
    }
}

?>