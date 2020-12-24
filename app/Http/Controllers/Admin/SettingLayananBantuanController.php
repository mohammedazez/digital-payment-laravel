<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\AppModel\LayananBantuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingLayananBantuanController extends Controller
{
    public function index()
    {
        $layanan = LayananBantuan::all()->toArray();
        // dd($layanan);
        return view('admin.pengaturan.layanan-bantuan.index', compact('layanan'));
    }

    public function store(Request $request)
    {
          DB::beginTransaction();
          try {
            $data =  $request->arrOut;
            LayananBantuan::truncate();
            for($i=0; $i < count($data);$i++){
                $simpan = new LayananBantuan();
                $simpan->icon        = strtolower($data[$i][0]);
                $simpan->title       = $data[$i][1];
                $simpan->description = $data[$i][2];
                $simpan->save();
            }
            DB::commit();
            return 'success';
          } catch (\Exception $e) {
            DB::rollback();
            //dd($e);
            return redirect()->back()->with('alert-error', $e->getMessage);
          }
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'min_deposit' => 'required',
        ],[
            'min_deposit.required' => 'Minimal Nominal tidak boleh kosong',
        ]);

        $nominal = str_replace(".", "", $request->min_deposit);
        DB::table('settings_min_deposit')
            ->update([
                'minimal_nominal' => $nominal,
        ]);

        return redirect()->back()->with('alert-success', 'Berhasil Melakukan Perubahan Data Sistem');
    }
}