<?php

namespace App\Http\Controllers\Admin;

use App\AppModel\PaypalSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingPayPalController extends Controller
{
    public function index()
    {
    	$settings = [];
    	foreach( PaypalSetting::get() as $pp )
    	{
    	    $settings[$pp->name] = $pp->value;
    	}
    	
    	return view('admin.pengaturan.paypal', compact('settings'));
    }

    public function save(Request $request)
    {
        $this->validate($request,[
            'min_amount' => 'required|numeric',
            'start_hour' => 'required|date_format:H:i:s',
            'end_hour' => 'required|date_format:H:i:s',
        ],[
            'min_amount.required' => 'Jumlah minimum pembelian tidak boleh kosong',
            'min_amount.numeric' => 'Jumlah minimum pembelian tidak valid',
            'start_hour.required' => 'Jam mulai aktif boleh kosong',
            'start_hour.date_format' => 'Jam mulai aktif tidak valid',
            'end_hour.required' => 'Jam akhir aktif tidak boleh kosong',
            'end_hour.date_format' => 'Jam akhir aktif tidak valid',
        ]);

        foreach( $request->only('min_amount', 'start_hour', 'end_hour') as $name => $value )
        {
            PaypalSetting::where('name', $name)->update([
                'value' => $value
                ]);
        }
        
        return redirect()->back()->with('alert-success', 'Berhasil Melakukan Perubahan Pengaturan PayPal');
    }
}