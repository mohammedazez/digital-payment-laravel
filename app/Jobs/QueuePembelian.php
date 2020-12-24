<?php

namespace App\Jobs;

use DB, Exception, Log, DigiFlazz,Auth,Validator,Input,Pulsa;
use App\User;
use App\AppModel\Pembelianproduk;
use App\AppModel\Transaksi;
use App\AppModel\Temptransaksi;
use App\AppModel\Antriantrx;
use App\AppModel\Mutasi;
use App\AppModel\Setting;
use App\Jobs\QueueTransaksi;
use Carbon\Carbon;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueuePembelian implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    public $apiserver_id;
    public $produk;
    public $type;
    public $code;
    public $target;
    public $no_meter_pln;
    public $user;
    public $ip_address;
    public $antrian_id;
    public $mutasi_id;
    public $via;
    public $jenis_transaksi;
    public $sequence = 0;
    
    private $personal_role      = 1;
    private $admin_role         = 2;
    private $agen_role          = 3;
    private $enterprise_role    = 4;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($apiserver_id,$produk, $type, $code, $target, $no_meter_pln, $user, $ip_address, $antrian_id, $mutasi_id, $via, $jenis_transaksi)
    {
        $this->apiserver_id    = $apiserver_id;
        $this->produk          = $produk;
        $this->type            = $type;
        $this->code            = $code;
        $this->target          = $target;
        $this->no_meter_pln    = $no_meter_pln;
        $this->user            = $user;
        $this->ip_address      = $ip_address;
        $this->antrian_id      = $antrian_id;
        $this->mutasi_id       = $mutasi_id;
        $this->via             = $via;
        $this->jenis_transaksi = $jenis_transaksi;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $produk = $this->produk;
       
    	if( !$produk ) return;
        
        $antrian = Antriantrx::find($this->antrian_id);
        
        if(!$antrian){
            return;
        }
        
        $order = '';
        
        DB::statement("SET session wait_timeout=300");
        
        DB::beginTransaction();
        
        $id= null;
    
        try
        {
        // 	$cs = date('Y-m-d').' 00:00:00';
        //     $duplicate = Transaksi::where('code', $this->code)->where('target', $this->target)->whereIn('status', [0, 1])->whereBetween('created_at', [$cs, date('Y-m-d H:i:s')])->first();
            
        //     if( !empty($duplicate) ) {
        //         throw new Exception('Transaksi '.$duplicate->product.' '.(!empty($this->no_meter_pln) ? $this->no_meter_pln : $this->target).' sudah pernah dilakukan pada '.strftime("%d %b %Y %H:%M", strtotime($duplicate->created_at)).'. Mohon gunakan nominal atau nomor tujuan yang berbeda');
        //     }
            
            $duplicateAntrian = (int) Transaksi::where('antrian_id', $this->antrian_id)->count();
            
            if( $duplicateAntrian <= 0 )
            {
                $transaksisSukses = new Transaksi();
                $transaksisSukses->apiserver_id = $this->apiserver_id;
                $transaksisSukses->code = $this->code;
                $transaksisSukses->antrian_id = $this->antrian_id;
                $transaksisSukses->produk = $produk->product_name;
                $transaksisSukses->harga_default = !empty($this->user->referred_by) ? ($produk->price - upline_markup()) :  $produk->price_default;
                $transaksisSukses->harga_markup = !empty($this->user->referred_by) ? upline_markup() : $produk->price_markup;
                $transaksisSukses->target = $this->target;
                
                if( !empty($this->no_meter_pln) )
                {
                    $transaksisSukses->mtrpln = $this->no_meter_pln;
                }
        
                if( $produk->pembelianoperator->product_id == 'PLN' )
                {
                    $transaksisSukses->note = "Trx ".$produk->product_name." ke ".$this->no_meter_pln." Akan Diproses.";
                }
                else
                {
                    $transaksisSukses->note = "Trx ".$produk->product_name." ke ".$this->target." Akan Diproses.";
                }
                
                $transaksisSukses->pengirim = $this->ip_address;
                $transaksisSukses->user_id = $this->user->id;
                $transaksisSukses->via = $this->via;
                $transaksisSukses->jenis_transaksi = $this->jenis_transaksi;
                $transaksisSukses->saldo_before_trx = $this->user->saldo + $produk->price;
                $transaksisSukses->saldo_after_trx = $this->user->saldo;
                $transaksisSukses->valid_sequence = 1;
                $transaksisSukses->save();
            
                $trxid = $transaksisSukses->id;
                $id    = $trxid;
                
                $affectedRows = Transaksi::where('id',$transaksisSukses->id)->update([
                     'order_id'=>$trxid
                ]);
                
                if(!$affectedRows){
                    throw new Exceptin('Internal service error. Please try again');
                }
            
                $mutasi = Mutasi::find($this->mutasi_id);
                $mutasi->trxid = $transaksisSukses->id;
                $mutasi->save();
                
                $td = Carbon::today()->setTimeZone('Asia/Jakarta');
                
                if($produk->pembelianoperator->product_id == 'PLN'){
                    $this->sequence = (int) Transaksi::where('valid_sequence',1)->where('code',$this->code)->where('mtrpln',$this->no_meter_pln)->whereBetween('created_at',[$td->format('Y-m-d H:i:s'),$td->addHours(24)->format('Y-m-d H:i:s')])->count();

                    $order = Pulsa::trx_pembelian('PLN',$this->code,$this->target,null,$this->no_meter_pln);
                }else{
                    $this->sequence = (int) Transaksi::where('valid_sequence',1)->where('code',$this->code)->where('target',$this->target)->whereBetween('created_at',[$td->format('Y-m-d H:i:s'),$td->addHours(24)])->count();

                    $order = Pulsa::trx_pembelian('I',$this->code,$this->target,null);
                }
                $transaksisSukses->sequence_id = $this->sequence;
                $transaksisSukses->save();

                if($order->success == true){
                    $transaksisSukses->order_id = $order->trxid;
                    $transaksisSukses->note = $order->message;
                    $transaksisSukses->save();
                }else{
                    throw new Exception($order->message);
                }
            }
    
    	    DB::commit();
    	}
    	catch(Exception $e)
    	{
    		DB::rollback();
    		
    		if( $e instanceof \Illuminate\Database\QueryException ) {
    		    Log::error($e);
    		}
    
    		$transaksisGagal                   = new Transaksi();
    		if(!is_null($id)){
    		    $transaksisGagal->id = $id;
    		}
    		$transaksisGagal->apiserver_id     = $this->apiserver_id;
            $transaksisGagal->code             = $this->code;
            $transaksisGagal->antrian_id 	   = $this->antrian_id;
            $transaksisGagal->produk           = $produk->product_name;
            $transaksisGagal->harga_default    = !empty($this->user->referred_by) ? ($produk->price - upline_markup()) :$produk->price_default;
            $transaksisGagal->harga_markup     = !empty($this->user->referred_by) ? upline_markup(): $produk->price_markup;
            $transaksisGagal->target           = $this->target;
            
            if (!empty($this->no_meter_pln)) {
                 $transaksisGagal->mtrpln           = $this->no_meter_pln;
            }
            $transaksisGagal->note             = $e->getMessage();
            $transaksisGagal->pengirim         = $this->ip_address;
            $transaksisGagal->user_id          = $this->user->id;
            $transaksisGagal->via              = $this->via;
            $transaksisGagal->jenis_transaksi  = $this->jenis_transaksi;
            $transaksisGagal->saldo_before_trx = $this->user->saldo + $produk->price;
            $transaksisGagal->saldo_after_trx  = $this->user->saldo + $produk->price;
            $transaksisGagal->status           = 2;
            $transaksisGagal->valid_sequence   = ($e->getCode() == 1 ? 1 : 0);
            $transaksisGagal->sequence_id      = ($transaksisGagal->valid_sequence == 1 ? $this->sequence : 0);
            $transaksisGagal->save();
            
            Transaksi::where('id',$transaksisGagal->id)->update([
                'order_id'  =>$transaksisGagal->id
            ]);
            
            $users        = User::findOrFail($this->user->id);
            $sisaSaldo    = $users->saldo + $produk->price;
            $users->saldo = $sisaSaldo;
            $users->save();
    
            $mutasi        = Mutasi::findOrFail($this->mutasi_id);
            $mutasi->trxid = $transaksisGagal->id;
            $mutasi->save();
            
            $mutasi          = new Mutasi();
            $mutasi->trxid   = $transaksisGagal->id;
            $mutasi->user_id = $this->user->id;
            $mutasi->type    = 'credit';
            $mutasi->nominal = $produk->price;
            $mutasi->saldo   = $sisaSaldo;
            $mutasi->note    = !empty($this->no_meter_pln) ? 'TRANSAKSI '.$produk->product_name.' '.$this->no_meter_pln.' GAGAL' : 'TRANSAKSI '.$produk->product_name.' '.$this->target.' GAGAL';
            $mutasi->save();
    
            ## Setelah membuat record transaksi baru, trigger temp transaksi dijalankan dengan transaksi_id = $transaksisGagal->id
    
            // hapus temptrnasaksis
             DB::table('temptransaksis')
                ->where('transaksi_id', $transaksisGagal->id)
                ->delete();
    	}
    
    	$antrian         = Antriantrx::findOrFail($this->antrian_id);
        $antrian->note   = 'Transaksi berhasil diproses.';
        $antrian->status = 1;
        $antrian->save();
    }
}
