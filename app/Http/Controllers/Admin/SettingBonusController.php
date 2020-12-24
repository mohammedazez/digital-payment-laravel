<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\AppModel\Bonus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
class SettingBonusController extends Controller
{
    public function index()
    {
        $getDataTrx = Bonus::getKomisi('1');
        // $getDataRef1 = Bonus::getKomisi('3');
        // $getDataRef2 = Bonus::getKomisi('4');
        // $getDataRef3 = Bonus::getKomisi('5');
        // dd($getDataTrx->komisi);
        return view('admin.pengaturan.bonus.index', compact('getDataTrx'));
    }

    // public function update(Request $request)
    // {
    //     $this->validate($request,[
    //             'bonus_ref1'=>'required',
    //             'bonus_ref2'=>'required',
    //             'bonus_ref3'=>'required',
    //         ],[
    //             'bonus_ref1.required'=>'Harap isi Bonus Referral User 1',
    //             'bonus_ref2.required'=>'Harap isi Bonus Referral User 2',
    //             'bonus_ref3.required'=>'Harap isi Bonus Referral User 3',
    //         ]);
        
    //     if($request->bonus_ref1)
    //     {
    //         // $caption = 'bonus_trx';
    //         $nominal1 = str_replace(".", "", $request->bonus_ref1);
    //     } 
    //     if($request->bonus_ref2){
    //         $nominal2 = str_replace(".", "", $request->bonus_ref2);
    //         // $caption = 'bonus_ref';
    //     }
    //     if($request->bonus_ref3){
    //         $nominal3 = str_replace(".", "", $request->bonus_ref3);
    //         // $caption = 'bonus_ref';
    //     }


    //     // $this->validate($request,[
    //     //     ''.$caption.'' => 'required',
    //     // ],[
    //     //     ''.$caption.'.required' => 'Nominal tidak boleh kosong',
    //     // ]);
    //     // DB::table('settings_komisi')
    //     //     ->where('id', $request->id)
    //     //     ->update([
    //     //         'komisi' => $nominal,
    //     // ]);
        
    //     if($request->bonus_ref1){
    //         DB::table('settings_komisi')
    //             ->where('id',3)
    //             ->update([
    //                 'komisi'=>$nominal1
    //             ]);
    //     }
    //      if($request->bonus_ref2){
    //         DB::table('settings_komisi')
    //             ->where('id',4)
    //             ->update([
    //                 'komisi'=>$nominal2
    //             ]);
    //     }
    //      if($request->bonus_ref3){
    //         DB::table('settings_komisi')
    //             ->where('id',5)
    //             ->update([
    //                 'komisi'=>$nominal3
    //             ]);
    //     }

    //     return redirect()->back()->with('alert-success', 'Berhasil Melakukan Perubahan Data Sistem');
    // }
    
    public function update(Request $request){
         $this->validate($request,[
                'bonus_trx'=>'required',
            ],[
                'bonus_trx.required'=>'Harap isi Bonus Referral User',
            ]);
        $nominal = str_replace(".", "", $request->bonus_trx);
        DB::table('settings_komisi')
            ->where('id',1)
            ->update([
                    'komisi'=>$nominal
                ]);
        return redirect()->back()->with('alert-success', 'Berhasil Melakukan Perubahan Data Sistem');
    }

}