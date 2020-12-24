<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\AppModel\Kurs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingKursController extends Controller
{
    public function index()
    {
        $kurs = Kurs::getKurs();
        return view('admin.pengaturan.kurs.index', compact('kurs'));
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'idr_usd' => 'required',
        ],[
            'idr_usd.required' => 'Kurs idr_usd tidak boleh kosong',
        ]);

        $idr_usd = str_replace(".", "", $request->idr_usd);
        
        DB::table('settings_kurs')
            ->where('name', '=', 'idr_usd')
            ->update([
                'value' => $idr_usd,
            ]);

        return redirect()->back()->with('alert-success', 'Berhasil Melakukan Perubahan Data Sistem');
    }
}