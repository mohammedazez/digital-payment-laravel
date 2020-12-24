<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\AppModel\Deposit;
use App\AppModel\SettingMinDeposit;
use App\AppModel\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingDepositController extends Controller
{
    public function index()
    {
        $minDeposit = SettingMinDeposit::all();
        $fee_deposit = Setting::first()->deposit_fee;
        return view('admin.pengaturan.min_deposit.index', compact('minDeposit','fee_deposit'));
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'min_deposit_personal'   => 'required',
            'min_deposit_admin'      => 'required',
            'min_deposit_agen'       => 'required',
            'min_deposit_enterprise' => 'required',
        ],[
            'min_deposit_personal.required'   => 'Minimal Nominal Deposit Personal tidak boleh kosong',
            'min_deposit_admin.required'      => 'Minimal Nominal Deposit Admin tidak boleh kosong',
            'min_deposit_agen.required'       => 'Minimal Nominal Deposit Agen Personal tidak boleh kosong',
            'min_deposit_enterprise.required' => 'Minimal Nominal Deposit Enterprise tidak boleh kosong',
        ]);
        DB::beginTransaction();
        try {
            $nominal_personal   = str_replace(".", "", $request->min_deposit_personal);
            $nominal_admin      = str_replace(".", "", $request->min_deposit_admin);
            $nominal_agen       = str_replace(".", "", $request->min_deposit_agen);
            $nominal_enterprise = str_replace(".", "", $request->min_deposit_enterprise);
            
            $SetMinDepositPersonal = SettingMinDeposit::findOrFail('1');
            $SetMinDepositPersonal->minimal_nominal = $nominal_personal;
            $SetMinDepositPersonal->save();
            
            $SetMinDepositAdmin = SettingMinDeposit::findOrFail('2');
            $SetMinDepositAdmin->minimal_nominal = $nominal_admin;
            $SetMinDepositAdmin->save();
            
            $SetMinDepositAgen = SettingMinDeposit::findOrFail('3');
            $SetMinDepositAgen->minimal_nominal = $nominal_agen;
            $SetMinDepositAgen->save();
            
            $SetMinDepositEnterprise = SettingMinDeposit::findOrFail('4');
            $SetMinDepositEnterprise->minimal_nominal = $nominal_enterprise;
            $SetMinDepositEnterprise->save();
            DB::commit();
            return redirect()->back()->with('alert-success', 'Berhasil Melakukan Perubahan Data Sistem');
        } catch (\Exception $e) {
            DB::rollback();
            //dd($e);
             return redirect()->back()->with('alert-error', $e->getMessage);
        }
    }
    
    public function fee_deposit(Request $request){
        $this->validate($request,[
            'deposit_fee'=>'required',
        ],[
            'deposit_fee.required'=>'Harap isi fee Deposit',
        ]);
        $nominal = str_replace(".","",$request->deposit_fee);
        $setting = Setting::first();

        $setting->deposit_fee = $nominal;
        $setting->save();
        return redirect()->back()->with('alert-success','Berhasil Melakukan Perubahan Data Sistem');
    }
}
