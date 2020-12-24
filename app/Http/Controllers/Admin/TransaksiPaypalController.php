<?php

namespace App\Http\Controllers\Admin;

use Pulsa, Response;
use App\User;
use App\AppModel\Mutasi;
use App\AppModel\Antriantrx;
use App\AppModel\Transaksi;
use App\AppModel\Transaksi_paypal;
use App\AppModel\Pembelianproduk;
use App\AppModel\Deposit;
use App\AppModel\Tagihan;
use App\AppModel\Redeem;
use App\AppModel\SMSGateway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use DB;
use Auth;
use Image;
use File;

class TransaksiPaypalController  extends Controller
{
    public function index()
    {
        $antrianMobile = Transaksi_paypal::orderBy('created_at','DESC')->paginate(10);
        return view('admin.transaksi.paypal.index', compact( 'antrianMobile'));
    }

    public function getDatatable()
    { 
             $data = Transaksi_paypal::orderBy('created_at','DESC')->get();
             
             return DataTables::collection($data)

             ->editColumn('id',function($data){
                    return '#'.$data->id.'';
             })

             ->editColumn('name',function($data){
                    return '<td>'.$data->user->name.'</td>';
             })
             
             ->editColumn('fee',function($data){
                 return '<td><span class="label label-info">Rp. '.number_format($data->fee, 0, '.', '.').'</span></td>';
             })
             
             ->editColumn('rate',function($data){
                    return '<td><span class="label label-info">Rp. '.number_format($data->rate, 0, '.', '.').'</span></td>';
             })
             
             ->editColumn('transaksi_code',function($data){
                 if($data->transaksi_code == '' || $data->transaksi_code == null){
                    return '<td>-</span></td>';
                 }else{
                    return '<td>'.$data->transaksi_code.'</td>';
                 }
             })
             
             ->editColumn('nominal_usd',function($data){
                    return '<td><span class="label label-info">$'.number_format($data->nominal_usd, 0, '.', '.').'</span></td>';
             })
             
             ->editColumn('nominal_idr',function($data){
                    return '<td><span class="label label-info">Rp. '.number_format($data->nominal_idr, 0, '.', '.').'</span></td>';
             })
             
             ->editColumn('total',function($data){
                    return '<td><span class="label label-info">Rp. '.number_format($data->total, 0, '.', '.').'</span></td>';
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
                    return '<a href="'.url("/admin/transaksi/paypal", $data->id).'" class="btn-loading label label-primary">DETAIL</a>';
                })

             ->rawColumns(['id','name','fee','rate','nominal_usd','nominal_idr','total','transaksi_code','created_at','status','action'])
             ->make(true);
    }

    public function showTransaksi($id)
    {
        $data = Transaksi_paypal::findOrFail($id);
        return view('admin.transaksi.paypal.show', compact('data'));
    }

    public function trxMenunggu(Request $request)
    { 
        DB::beginTransaction();
        try {
            
            $id         = $request->id;
            $note       = $request->note;
            
            $updateTabel = Transaksi_paypal::findOrFail($id);
            $updateTabel->status = '0';
            $updateTabel->transaksi_code = NULL;
            $updateTabel->img = NULL;
            $updateTabel->note = ($note !='')?$note:'Transaksi Pending';
            $updateTabel->save();
            
            $updateTransaksi = Transaksi::where('order_id', $updateTabel->trxid)->first();
            $updateTransaksi->status='0';
            $updateTransaksi->token='-';
            $updateTransaksi->note = ($note !='')?$note:'Transaksi Pending';
            $updateTransaksi->save();
            
            DB::commit();
            return redirect()->back()->with('alert-error', 'Berhasil Merubah Status!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }    
    }

    public function trxRefund(Request $request)
    {
        DB::beginTransaction();
        try {
            
             $id             = $request->id;
             $note       = $request->note;
             
             $getData         = Transaksi_paypal::findOrFail($id);
             $sumSaldoNominal = $getData->user->saldo + $getData->total;
             $noteFee         = $getData->fee;
                
            //insert ke mutasi
             $mutasi = new Mutasi();
             $mutasi->trxid   = $getData->trxid;
             $mutasi->user_id = $getData->user_id;
             $mutasi->type    = 'credit';
             $mutasi->nominal = $getData->total;
             $mutasi->saldo   = $sumSaldoNominal;
             $mutasi->note    = ($note !='')?$note:'TRANSAKSI Pembelian Saldo Paypal ke Akun '.$getData->address_paypal.' Sebesar $'.$getData->nominal_usd.', Rate '.number_format($getData->rate, 0, '.', '.').', fee '.$noteFee.'  dengan Total Rp. '.number_format($getData->total, 0, '.', '.').' Di Refund, Saldo Dikembalikan';
             $mutasi->save();
             
             sleep(2);
             
             $user        = User::findOrFail($getData->user_id);
             $user->saldo = $sumSaldoNominal;
             $user->save();
            
             sleep(2);
            
            $updateTabel = Transaksi_paypal::findOrFail($id);
            $updateTabel->status = '2';
            $updateTabel->transaksi_code = NULL;
            $updateTabel->img = NULL;
            $updateTabel->note    = ($note !='')?$note:'TRANSAKSI Pembelian Saldo Paypal ke Akun '.$getData->address_paypal.' Sebesar $'.$getData->nominal_usd.', Rate '.number_format($getData->rate, 0, '.', '.').', fee '.$noteFee.'  dengan Total Rp. '.number_format($getData->total, 0, '.', '.').' Di Refund';
            $updateTabel->save();
            
            $updateTransaksi = Transaksi::where('order_id', $updateTabel->trxid)->first();
            $updateTransaksi->status='2';
            $updateTransaksi->token='-';
            $updateTransaksi->note    = ($note !='')?$note:'TRANSAKSI Pembelian Saldo Paypal ke Akun '.$getData->address_paypal.' Sebesar $'.$getData->nominal_usd.', Rate '.number_format($getData->rate, 0, '.', '.').' dengan Total Rp. '.number_format($getData->total, 0, '.', '.').' Di Refund';
            $updateTransaksi->saldo_before_trx = $getData->user->saldo;
            $updateTransaksi->saldo_after_trx  = $sumSaldoNominal ;
            $updateTransaksi->save();
            
            
            if($getData->img != null){
                foreach( explode(",", $getData->img) as $img )
                {
                    $img = trim($img);
                    
                    if (file_exists(public_path('/img/saldo_paypal/bukti_trx/'.$img))) {
                        unlink(public_path('/img/saldo_paypal/bukti_trx/'.$img));
                    } 
                    if (file_exists(public_path('/img/saldo_paypal/bukti_trx/thumb/'.$img))) {
                        unlink(public_path('/img/saldo_paypal/bukti_trx/thumb/'.$img));
                    }
                }
            }
            
            DB::commit();
            
            return redirect()->back()->with('alert-error', 'Berhasil Merubah Status!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }    
    }

    public function trxSuccess(Request $request)
    {
        DB::beginTransaction();
        try {
            $id             = $request->id;
            $pengirim       = implode(",", $request->email_pengirim);
            $transaksi_code = implode(",", $request->transaksi_code);
            $note           = $request->note;
            
            $getData        = Transaksi_paypal::findOrFail($id);
            $noteFee         = $getData->fee;
            $files = [];
                    
            if($request->hasFile('bukti_trx'))
            {
                $destinationORI_TEMP = public_path('img/saldo_paypal/bukti_trx/temp');
                $destinationIMG      = public_path('img/saldo_paypal/bukti_trx/');
                $destinationThumb    = public_path('img/saldo_paypal/bukti_trx/thumb');
                
                if (!file_exists($destinationORI_TEMP)) {
                    mkdir($destinationORI_TEMP, 0777, true);
                }
                
                if (!file_exists($destinationThumb)) {
                    mkdir($destinationThumb, 0777, true);
                }
                
                foreach( $request->file('bukti_trx') as $fileTRX )
                {
                    $fileNameTRX      = 'bukti_trx_'.Auth::user()->id.uniqid().'.'.$fileTRX->getClientOriginalExtension();
                
                    $fileTRX->move($destinationORI_TEMP, $fileNameTRX);
                    
                    $img = Image::make($destinationORI_TEMP.'/'.$fileNameTRX);
                    $img->backup();
                    
                    $img->resize(20, 30);
                    $img->save($destinationThumb.'/'.$fileNameTRX, 80);
                    
                    $img->reset();
                    
                    $img->resize(740, 580);
                    $img->save($destinationIMG.'/'.$fileNameTRX, 80);
                    
                    $img->destroy();
                    
                    File::delete([$destinationORI_TEMP.'/'.$fileNameTRX]);
                    
                    $files[] = $fileNameTRX;
                }
            }
            
            $updateTabel = Transaksi_paypal::findOrFail($id);
            $updateTabel->status = '1';
            $updateTabel->address_paypal_pengirim = $pengirim;
            $updateTabel->transaksi_code = ($transaksi_code !='') ? $transaksi_code : NULL;
            $updateTabel->img = $request->hasFile('bukti_trx') ? implode(",", $files) : NULL; 
            $updateTabel->note=($note !='')?$note:'TRANSAKSI Pembelian Saldo Paypal ke Akun '.$getData->address_paypal.' Sebesar $'.$getData->nominal_usd.', Rate '.number_format($getData->rate, 0, '.', '.').' dengan Total Rp. '.number_format($getData->total, 0, '.', '.').' BERHASIL. TRX.KODE #'.$transaksi_code.'.';
            $updateTabel->save();
            
            $updateTransaksi = Transaksi::where('order_id', $updateTabel->trxid)->first();
            $updateTransaksi->status='1';
            $updateTransaksi->token= ($transaksi_code !='')?$transaksi_code:'-';
            $updateTransaksi->note=($note !='')?$note:'TRANSAKSI Pembelian Saldo Paypal ke Akun '.$getData->address_paypal.' Sebesar $'.$getData->nominal_usd.', Rate '.number_format($getData->rate, 0, '.', '.').' dengan Total Rp. '.number_format($getData->total, 0, '.', '.').' BERHASIL. TRX.KODE #'.$transaksi_code.'.';
            $updateTransaksi->save();
            
            DB::commit();
            
            return redirect()->back()->with('alert-success', 'Berhasil Merubah Status!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }    
        
    }
    
    public function trxGagal(Request $request)
    {
        DB::beginTransaction();
        try {
            
             $id             = $request->id;
             $note           = $request->note;
             
             $getData         = Transaksi_paypal::findOrFail($id);
             $sumSaldoNominal = $getData->user->saldo + $getData->total;
             $noteFee         = $getData->fee;
                
            //insert ke mutasi
             $mutasi = new Mutasi();
             $mutasi->trxid   = $getData->trxid;
             $mutasi->user_id = $getData->user_id;
             $mutasi->type    = 'credit';
             $mutasi->nominal = $getData->total;
             $mutasi->saldo   = $sumSaldoNominal;
             
             $mutasi->note    = ($note !='')?$note:'TRANSAKSI Pembelian Saldo Paypal ke Akun '.$getData->address_paypal.' Sebesar $'.$getData->nominal_usd.', Rate '.number_format($getData->rate, 0, '.', '.').' dengan Total Rp. '.number_format($getData->total, 0, '.', '.').' Gagal, Saldo Dikembalikan';
             $mutasi->save();
             
             sleep(2);
             
             $user        = User::findOrFail($getData->user_id);
             $user->saldo = $sumSaldoNominal;
             $user->save();
            
             sleep(2);
             
            
            $updateTabel = Transaksi_paypal::findOrFail($id);
            $updateTabel->status = '2';
            $updateTabel->transaksi_code = NULL;
            $updateTabel->img = NULL;
            $updateTabel->note = ($note !='')?$note:'TRANSAKSI Pembelian Saldo Paypal ke Akun '.$getData->address_paypal.' Sebesar $'.$getData->nominal_usd.', Rate '.number_format($getData->rate, 0, '.', '.').' dengan Total Rp. '.number_format($getData->total, 0, '.', '.').' Gagal';
            $updateTabel->save();
            
            $updateTransaksi = Transaksi::where('order_id', $updateTabel->trxid)->first();
            $updateTransaksi->status='2';
            $updateTransaksi->note=($note !='')?$note:'TRANSAKSI Pembelian Saldo Paypal ke Akun '.$getData->address_paypal.' Sebesar $'.$getData->nominal_usd.', Rate '.number_format($getData->rate, 0, '.', '.').' dengan Total Rp. '.number_format($getData->total, 0, '.', '.').' Gagal';
            $updateTransaksi->token='-';
            
            $updateTransaksi->saldo_before_trx = $getData->user->saldo;
            $updateTransaksi->saldo_after_trx  = $sumSaldoNominal ;
            $updateTransaksi->save();
            
            if($getData->img != null){
                foreach( explode(",", $getData->img) as $img )
                {
                    $img = trim($img);
                    
                    if (file_exists(public_path('/img/saldo_paypal/bukti_trx/'.$img))) {
                        unlink(public_path('/img/saldo_paypal/bukti_trx/'.$img));
                    }
                    if (file_exists(public_path('/img/saldo_paypal/bukti_trx/thumb/'.$img))) {
                        unlink(public_path('/img/saldo_paypal/bukti_trx/thumb/'.$img));
                    }
                }
            }
            
            DB::commit();
            
            return redirect()->back()->with('alert-success', 'Berhasil Merubah Status!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }  
    }

}