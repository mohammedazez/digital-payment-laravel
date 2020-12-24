<?php

namespace App\Http\Controllers\Admin;

use Response, DB, Auth;
use App\User;
use App\AppModel\Mutasi;
use App\AppModel\Antriantrx;
use App\AppModel\Transaksi;
use App\AppModel\Pembelianproduk;
use App\AppModel\Mutasi_saldobank;
use App\AppModel\Deposit;
use App\AppModel\Tagihan;
use App\AppModel\Redeem;
use App\AppModel\SendSMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class TransferBankController  extends Controller
{
    public function index()
    {
        $antrianMobile = Mutasi_saldobank::orderBy('created_at','DESC')->paginate(10);
        return view('admin.transaksi.transfer-bank.index', compact( 'antrianMobile'));
    }

    public function datatables()
    { 
            $data = Mutasi_saldobank::orderBy('created_at','DESC')->get();
            
             return DataTables::collection($data)

             ->editColumn('id',function($data){
                    return '<a href="'.url("/admin/transaksi/transfer-bank", $data->id).'">#'.$data->id.'</a>';
             })
             
             ->editColumn('name',function($data){
                    return '<a href="'.url("/admin/users", $data->user->id).'">'.$data->user->name.'</a>';
             })


             ->editColumn('nominal',function($data){
                    return '<td><span class="label label-info">Rp. '.number_format($data->nominal, 0, '.', '.').'</span></td>';
             })
             
             ->editColumn('created_at',function($data){
                    return Carbon::parse($data->created_at)->format('d-m-Y H:i:s');
             })

             ->editColumn('status',function($data){
                if($data->status == 0){
                    return '<td><span class="label label-warning">PROSES</span></td>';
                }elseif($data->status == 1){
                    return '<td><span class="label label-success">BERHASIL</span></td>';
                }elseif($data->status == 2){
                    return '<td><span class="label label-danger">GAGAL</span></td>';
                }elseif($data->status == 3){
                    return '<td><span class="label label-primary">REFUND</span></td>';
                };
            })

             ->editColumn('action', function($data){
                    return '<a href="'.url("/admin/transaksi/transfer-bank", $data->id).'" class="btn-loading label label-primary">DETAIL</a>';
                })

             ->rawColumns(['id','name','nominal','created_at','status','action'])
             ->make(true);
    }

    public function show($id)
    {
        $data = Mutasi_saldobank::where('id',$id)->orderBy('created_at','DESC')->firstOrFail();
        return view('admin.transaksi.transfer-bank.show', compact('data'));
    }

    public function statusPending(Request $requset, $id)
    {
        DB::beginTransaction();
        
        try
        {
            $updateMutasiSaldo = Mutasi_saldobank::findOrFail($id);
            $updateMutasiSaldo->status = 0;
            $updateMutasiSaldo->note = 'Transaksi Diproses';
            $updateMutasiSaldo->save();
            DB::commit();
            
            return redirect()->back()->with('alert-success', 'Berhasil mengubah status transaksi');
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with('alert-error', $e->getMessage());
        }  
    }

    public function statusRefund(Request $requset,$id)
    {
        DB::beginTransaction();
        
        try
        {
             //get-user-saldo
             $getMutasi = Mutasi_saldobank::find($id);
             
             $sumSaldoNominal  = $getMutasi->user->saldo + $getMutasi->nominal;
             $sumSaldoAdmin    = $sumSaldoNominal + 2500;
    
            //insert ke mutasi
             $mutasi          = new Mutasi();
             $mutasi->user_id = $getMutasi->user_id;
             $mutasi->type    = 'credit';
             $mutasi->nominal = $getMutasi->nominal;
             $mutasi->saldo   = $sumSaldoNominal;
             $mutasi->note    = 'TRANSAKSI Pemindahan Saldo Rp. '.number_format($getMutasi->nominal, 0, '.', '.').' Ke '.$getMutasi->jenis_bank.' ('.$getMutasi->code_bank.') no.rekening '.$getMutasi->no_rekening.'. Refund, Saldo dikembalikan';
             $mutasi->save();
             
             sleep(5);
             
            //insert ke mutasi
             $mutasi_admin          = new Mutasi();
             $mutasi_admin->user_id = $getMutasi->user_id;
             $mutasi_admin->type    = 'credit';
             $mutasi_admin->nominal = '2500';
             $mutasi_admin->saldo   = $sumSaldoAdmin;
             $mutasi_admin->note    = 'Pengembalian Biaya Admin Transfer Saldo ID:#'.$getMutasi->id.' Rp.2.500 dikembalikan';
             $mutasi_admin->save();
    
             //update saldo
             $updatesado        = User::find($getMutasi->user_id);
             $updatesado->saldo = $sumSaldoAdmin;
             $updatesado->save();
                
            $sms_buyer = SendSMS::send($getMutasi->user->phone,  'TRANSAKSI Pemindahan Saldo Rp. '.number_format($getMutasi->nominal, 0, '.', '.').' Ke '.$getMutasi->jenis_bank.' ('.$getMutasi->code_bank.') no.rekening '.$getMutasi->no_rekening.'. REFUND');
            DB::commit();
            
            return redirect()->back()->with('alert-success', 'Berhasil merefund transaksi');
            
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with('alert-error', $e->getMessage());
        }  
        
    }

    public function statusSuccess($id)
    {
        DB::beginTransaction();
        
        try
        {
             $getMutasi = Mutasi_saldobank::find($id);
             $getMutasi->status = 1;
             $getMutasi->note = 'Transaksi Success.';
             $getMutasi->save();
             
             $sms_buyer = SendSMS::send($getMutasi->user->phone,  'TRANSAKSI Pemindahan Saldo Rp. '.number_format($getMutasi->nominal, 0, '.', '.').' Ke '.$getMutasi->jenis_bank.' ('.$getMutasi->code_bank.') no.rekening '.$getMutasi->no_rekening.'. SUKSES');

            DB::commit();
            return redirect()->back()->with('alert-success', 'Berhasil mengubah status transaksi');
            
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with('alert-error', $e->getMessage());
        }  
        
    }
    
    public function statusFailed(Request $request,$id)
    {
        DB::beginTransaction();
        
        try
        {
             $getMutasi         = Mutasi_saldobank::find($id);
             $getMutasi->status = 2;
             $getMutasi->note   = (isset($request->note))?$request->note:'Transaksi Gagal';
             $getMutasi->save();
    
             $sumSaldoNominal  = $getMutasi->user->saldo + $getMutasi->nominal;
             $sumSaldoAdmin    = $sumSaldoNominal + 2500;
                
            //insert ke mutasi
             $mutasi          = new Mutasi();
             $mutasi->user_id = $getMutasi->user_id;
             $mutasi->type    = 'credit';
             $mutasi->nominal = $getMutasi->nominal;
             $mutasi->saldo   = $sumSaldoNominal;
             $mutasi->note    = 'TRANSAKSI Pemindahan Saldo Rp. '.number_format($getMutasi->nominal, 0, '.', '.').' Ke '.$getMutasi->jenis_bank.' ('.$getMutasi->code_bank.') no.rekening '.$getMutasi->no_rekening.'. Gagal, Saldo dikembalikan';
             $mutasi->save();
             
             sleep(5);
             
            //insert ke mutasi
             $mutasi_admin          = new Mutasi();
             $mutasi_admin->user_id = $getMutasi->user_id;
             $mutasi_admin->type    = 'credit';
             $mutasi_admin->nominal = '2500';
             $mutasi_admin->saldo   = $sumSaldoAdmin;
             $mutasi_admin->note    = 'Pengembalian Biaya Admin Transfer Saldo ID:#'.$getMutasi->id.' Rp.2.500 dikembalikan';
             $mutasi_admin->save();
             
             //update saldo
             $updatesado        = User::find($getMutasi->user_id);
             $updatesado->saldo = $sumSaldoAdmin;
             $updatesado->save();
    
            $sms_buyer = SendSMS::send($getMutasi->user->phone,  'TRANSAKSI Pemindahan Saldo Rp. '.number_format($getMutasi->nominal, 0, '.', '.').' Ke '.$getMutasi->jenis_bank.' ('.$getMutasi->code_bank.') no.rekening '.$getMutasi->no_rekening.'. GAGAL');

            DB::commit();
            
            return redirect()->back()->with('alert-success', 'Berhasil merefund transaksi');
            
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with('alert-error', $e->getMessage());
        }  
    }
}
