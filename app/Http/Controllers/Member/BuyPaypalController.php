<?php

namespace App\Http\Controllers\Member;

use DB, Auth, Response, Validator, Mail;
use App\User;
use App\AppModel\Bank;
use App\AppModel\Mutasi;
use App\AppModel\Transaksi;
use App\AppModel\Rate;
use App\AppModel\Setting;
use App\AppModel\Temptransaksi;
use App\AppModel\Transaksi_paypal;
use App\AppModel\MenuSubmenu;
use App\AppModel\SMSGateway;
use App\AppModel\PaypalSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;

class BuyPaypalController extends Controller
{
    protected $ppsetting = [];
    
    public function __construct()
    {
        foreach( PaypalSetting::get() as $pp )
        {
            $this->ppsetting[$pp->name] = $pp->value;
        }
    }
    
    public function index()
    {
        $URL_uri = request()->segment(1).'/'.request()->segment(2);
        $datasubmenu2 = MenuSubmenu::getSubMenuOneMemberURL($URL_uri)->first();
        $rate = Rate::all();
        $rateLast = Rate::orderBy('id', 'desc')->first();
        $ppsetting = $this->ppsetting;
	    return view('member.pembelian.buypaypal', compact('rate','rateLast','ppsetting'));
    }


    public function processSaveTrx(Request $request)
    {
        $this->validate($request,[
            'address_paypal' => 'required|email',
            'nominal'        => 'required|numeric|min:5',
            'pin'            => 'required',
        ],[
            'address_paypal.required' => 'Alamat email Paypal tidak boleh kosong',
            'address_paypal.email'    => 'Format email paypal tidak valid',
            'nominal.required'        => 'Nominal Transaksi tidak boleh kosong',
            'nominal.numeric'         => 'Nominal Transaksi tidak valid',
            'nominal.min'             => 'Nominal Transaksi minimal $5.00',
            'pin.required'            => 'PIN tidak boleh kosong',
        ]);
        if(!preg_match('/[^W_]+/',$request->pin)){
            return redirect()->back()->with('alert-error','Pin yang anda masukkan tidak valid');
        }
        $cekUser = User::findOrFail(Auth::id());
        if($cekUser->status == 0){
            return redierect()->back()->with('alert-error','Maaf akun anda dinonaktifkan');
        }
        if($cekUser->status_saldo == 0){
            return redirect()->back()->with('alert-error','Maaf saldo anda dikunci oleh admin dan tidak bisa digunakan');
        }
        if( $request->nominal < intval($this->ppsetting['min_amount']) ){
            $message = 'Minimal Transaksi adalah $'.number_format(intval($this->ppsetting['min_amount']), 2, ',', '').'!';
            
            if( $request->wantsJson() ) {
                return Response::json(['success' => false, 'message' => $message]);
            } else {
                return redirect()->back()->with('alert-error', $message);
            }
        }


        if( $cekUser->pin != $request->pin )
        {
            $message = 'Pin anda salah';
                                                                                                                    
            if( $request->wantsJson() ) {
                return Response::json(['success' => false, 'message' => $message]);
            } else {
                return redirect()->back()->with('alert-error', $message);
            }
        }

        DB::beginTransaction();
        
        try
        {
           
            $address_paypal = $request->address_paypal;
            $nominal        = $request->nominal;
            $rate           = Rate::all();
            $rateLast       = Rate::orderBy('id', 'desc')->first();
            $kursPP         = intval($rateLast->rate);
            
            foreach($rate as $rates)
            {
                $USD_FROM = $rates->usd_from;
                $USD_TO   = $rates->usd_to;
                if( $request->nominal >= $USD_FROM && $request->nominal <=  $USD_TO)
                {
                    $kursPP = $rates->rate;
                }
            }

            $totalPembelian = intval($kursPP) * intval($nominal);
            $fee            = 0;
          

            if($cekUser->saldo < intval($totalPembelian)){
                $message = 'Maaf, Saldo anda tidak mencukupi untuk melakukan transaksi tersebut!';
                
                if( $request->wantsJson() ) {
                    return Response::json(['success' => false, 'message' => $message]);
                } else {
                    return redirect()->back()->with('alert-error', $message);
                }
            }

            $potongSaldo = $cekUser->saldo - intval($totalPembelian);
            $user = Auth::user();
            $user->saldo = $potongSaldo;
            $user->save();

            $transaksi = new Transaksi();
            $transaksi->code             = 'PAYPAL';
            $transaksi->produk           = 'SALDO PAYPAL ($'.$nominal.')';
            $transaksi->harga_default    = $totalPembelian;
            $transaksi->harga_markup     = $fee;
            $transaksi->target           = $request->address_paypal;
            $transaksi->mtrpln           = '-';
            $transaksi->note             = 'TRANSAKSI Pembelian Saldo Paypal ke Akun '.$address_paypal.' Sebesar $'.$nominal.', Rate '.number_format($kursPP, 0, '.', '.').' dengan Total Rp. '.number_format(intval($totalPembelian), 0, '.', '.').' Sedang Diproses ';
            $transaksi->pengirim         = $_SERVER['REMOTE_ADDR'];
            $transaksi->token            = '-';
            $transaksi->status           = '0';
            $transaksi->user_id          =  Auth::user()->id;
            $transaksi->via              = 'DIRECT';
            $transaksi->jenis_transaksi  = 'manual';
            $transaksi->saldo_before_trx = $cekUser->saldo + intval($totalPembelian);
            $transaksi->saldo_after_trx  = $potongSaldo;
            $transaksi->save();

            $transaksi->order_id = $transaksi->id;
            $transaksi->save();

            $trxPP = new Transaksi_paypal();
            $trxPP->user_id           = Auth::user()->id;
            $trxPP->trxid             = $transaksi->id;
            $trxPP->address_paypal    = $address_paypal;
            $trxPP->rate              = $kursPP;
            $trxPP->nominal_usd       = $nominal;
            $trxPP->nominal_idr       = $totalPembelian;
            $trxPP->fee               = $fee;
            $trxPP->total             = intval($totalPembelian);
            $trxPP->transaksi_code    = NULL;
            $trxPP->status            = '0';
            $trxPP->note              = 'TRANSAKSI Pembelian Saldo Paypal ke Akun '.$address_paypal.' Sebesar $'.$nominal.', Rate '.number_format($kursPP, 0, '.', '.').' dengan Total Rp. '.number_format(intval($totalPembelian), 0, '.', '.').' Sedang Diproses ';
            $trxPP->save();

            sleep(1);

			$query = DB::table('temptransaksis')
					->where('transaksi_id', $transaksi->id)
					->delete();
			//insert ke mutasi
             $mutasi = new Mutasi();
             $mutasi->trxid   =  $transaksi->id;
             $mutasi->user_id = Auth::user()->id();
             $mutasi->type    = 'debit';
             $mutasi->nominal = intval($totalPembelian);
             $mutasi->saldo   = $potongSaldo;
             $mutasi->note    = 'TRANSAKSI Pembelian Saldo Paypal ke Akun '.$address_paypal.' Sebesar $'.$nominal.', Rate '.number_format($kursPP, 0, '.', '.').' dengan Total Rp. '.number_format(intval($totalPembelian), 0, '.', '.').' Sedang Diproses ';
             $mutasi->save();
             
             $setting = Setting::first();
            
            DB::commit();
            
            SMSGateway::send($setting->hotline, 'Transaksi pembelian saldo PayPal $'.$nominal.' ke '.$address_paypal);

            $message = 'Pembelian sedang diproses dan akan dilakukan pengecekan oleh Admin. Silahkan cek transaksi Anda di <a href="/member/riwayat-transaksi" style="font-weight:bold;text-decoration:underline;">RIWAYAT TRANSAKSI</a>';
            
            if( $request->wantsJson() ) {
                return Response::json(['success' => true, 'message' => $message]);
            } else {
                return redirect()->back()->with('alert-success', $message);
            }
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            
            if( $request->wantsJson() ) {
                return Response::json(['success' => false, 'message' => $e->getMessage()]);
            } else {
                return redirect()->back()->with('alert-error', $e->getMessage());
            }
        }
        catch(Throwable $e)
        {
            DB::rollBack();
            
            if( $request->wantsJson() ) {
                return Response::json(['success' => false, 'message' => $e->getMessage()]);
            } else {
                return redirect()->back()->with('alert-error', $e->getMessage());
            }
        }
    }
}