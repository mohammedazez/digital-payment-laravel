<?php

namespace App\Http\Controllers\Admin;

use App\AppModel\Voucher;
use App\AppModel\GenerateCoupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class VoucherController extends Controller
{
    public function index()
    {
        $voucher = Voucher::orderBy('created_at', 'DESC')->get();
        return view('admin.voucher.index', compact('voucher'));
    }

    public function generateCode()
    {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        return $res;
    }
    
    public function create()
    {
        return view('admin.voucher.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request,[
                'code'         => 'required',
                'bonus'        => 'required',
                'expired_date' => 'required',
                'quant'        => 'required',
            ],[
                'code.required'         => 'Code Voucher tidak boleh kosong',
                'bonus.required'        => 'Bonus Voucher tidak boleh kosong',
                'expired_date.required' => 'Tanggal Expire Vocuher tidak boleh kosong',
                'quant.required'        => 'Jumlah Vocuher tidak boleh kosong',
            ]);
        
        $voucher = new Voucher();
        $voucher->code = $request->code;
        $voucher->bonus = $request->bonus;
        $voucher->expired_date = date("Y-m-d", strtotime($request->expired_date));
        $voucher->qty = $request->quant[2];
        if($request->status == 1){
            $voucher->status = 1;
        }else{
            $voucher->status = 0;
        }
       
           if( is_array($request->get('filtering')) )
        {
            for($i=0; $i < count($request->get('filtering')); $i++)
            {
                if($request->get('filtering')[$i] == 'B')
                {
                     if($request->date_masa_bergabung == ''){
                        return redirect()->back()->with('alert-error', 'Form isian tidak boleh kosong');
                     }
                     $voucher->filter_datereg_user = 1;
                     $voucher->value_datereg_user  = Carbon::parse($request->date_masa_bergabung)->format('Y-m-d');
                }
                
                if($request->get('filtering')[$i] == 'C')
                {
                     if($request->get('select_verif') == ''){
                        return redirect()->back()->with('alert-error', 'Form isian tidak boleh kosong');
                     }
                     $voucher->filter_verified     = 1;
                     $voucher->value_verified      = $request->get('select_verif');
                }
                
                if($request->get('filtering')[$i] == 'D')
                {
                     if($request->minimal_saldo == ''){
                        return redirect()->back()->with('alert-error', 'Form isian tidak boleh kosong');
                     }
                     $voucher->filter_saldo        = 1;
                     $voucher->value_saldo         = $request->minimal_saldo;
                }
                
                if($request->get('filtering')[$i] == 'E')
                {
                     if($request->maximal_saldo == ''){
                        return redirect()->back()->with('alert-error', 'Form isian tidak boleh kosong');
                     }
                     $voucher->filter_saldo_max     = 1;
                     $voucher->value_saldo_max      = $request->maximal_saldo;
                }
                
                if($request->get('filtering')[$i] == 'F')
                {
                     if($request->get('select_level') == ''){
                        return redirect()->back()->with('alert-error', 'Form isian tidak boleh kosong');
                     }
                     $voucher->filter_level_user     = 1;
                     $voucher->value_level_user      = $request->get('select_level');
                }
            }
        }
        $voucher->save();
        return redirect()->route('voucher.index')->with('alert-success', 'Berhasil Menambah Voucher');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.voucher.edit', compact('voucher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $this->validate($request,[
                'code'         => 'required',
                'bonus'        => 'required',
                'expired_date' => 'required',
                'quant'        => 'required',
            ],[
                'code.required'         => 'Code Voucher tidak boleh kosong',
                'bonus.required'        => 'Bonus Voucher tidak boleh kosong',
                'expired_date.required' => 'Tanggal Expire Vocuher tidak boleh kosong',
                'quant.required'        => 'Jumlah Vocuher tidak boleh kosong',
            ]);
        $voucher = Voucher::findOrFail($id);
        $voucher->code = $request->code;
        $voucher->bonus = $request->bonus;
        $voucher->expired_date = date("Y-m-d", strtotime($request->expired_date));
        $voucher->qty = $request->quant[2];
        if($request->status == 1){
            $voucher->status = 1;
        }else{
            $voucher->status = 0;
        }
        
        $voucher->filter_datereg_user = 0;
        $voucher->value_datereg_user  = NULL;
        $voucher->filter_verified     = 0;
        $voucher->value_verified      = NULL;
        $voucher->filter_saldo        = 0;
        $voucher->value_saldo         = NULL;
        $voucher->filter_saldo_max    = 0;
        $voucher->value_saldo_max     = NULL;
                 
        for($i=0; $i < count($request->get('filtering')); $i++){
 
            if($request->get('filtering')[$i] == 'B'){
                 if($request->date_masa_bergabung == ''){
                    return redirect()->back()->with('alert-error', 'Form isian tidak boleh kosong');
                 }
                 $voucher->filter_datereg_user = 1;
                 $voucher->value_datereg_user  = Carbon::parse($request->date_masa_bergabung)->format('Y-m-d');
            }
            
            if($request->get('filtering')[$i] == 'C'){
                 if($request->get('select_verif') == ''){
                    return redirect()->back()->with('alert-error', 'Form isian tidak boleh kosong');
                 }
                 $voucher->filter_verified     = 1;
                 $voucher->value_verified      = $request->get('select_verif');
            }
            
            if($request->get('filtering')[$i] == 'D'){
                 if($request->minimal_saldo == ''){
                    return redirect()->back()->with('alert-error', 'Form isian tidak boleh kosong');
                 }
                 $voucher->filter_saldo        = 1;
                 $voucher->value_saldo         = $request->minimal_saldo;
            }
            if($request->get('filtering')[$i] == 'E'){
                 if($request->maximal_saldo == ''){
                    return redirect()->back()->with('alert-error', 'Form isian tidak boleh kosong');
                 }
                 $voucher->filter_saldo_max     = 1;
                 $voucher->value_saldo_max      = $request->maximal_saldo;
            }
            if($request->get('filtering')[$i] == 'F'){
                 if($request->get('select_level') == ''){
                    return redirect()->back()->with('alert-error', 'Form isian tidak boleh kosong');
                 }
                 $voucher->filter_level_user     = 1;
                 $voucher->value_level_user      = $request->get('select_level');
            }
        }
        $voucher->save();
        return redirect()->route('voucher.index')->with('alert-success', 'Berhasil Merubah Data Voucher');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->redeem()->delete();
        $voucher->delete();
        return redirect()->route('voucher.index')->with('alert-success', 'Berhasil Menghapus Data Voucher');
    }
}
