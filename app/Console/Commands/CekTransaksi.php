<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AppModel\Transaksi;
use Pulsa;
use App\AppModel\Tagihan;
use App\AppModel\Mutasi;
use App\AppModel\Setting;
use App\AppModel\Temptransaksi;
use App\User;
use DB;
use Carbon\Carbon;
use App\AppModel\Bonus;

class CekTransaksi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaksi:cek';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek Status Transaksi';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        
        DB::beginTransaction();
        //Cek expired tagihan
        $time = Carbon::now()->subHours(24)->toDateTimeString();
        $tagihan = Tagihan::take(50)->get();
        foreach($tagihan as $item){
            if($item->created_at <= $time){
                $item->status =3;
                $item->expired =0;
                $item->save();
            }
        }
        try {
            $temp_transaksiCount = Temptransaksi::count();
            if ($temp_transaksiCount != null) {
                $temp_transaksi = Temptransaksi::all();
                foreach($temp_transaksi as $tmp){
                   
                    $transaksis = Transaksi::where('order_id', $tmp->transaksi->order_id)->first();
                    
                    //Cek transaksi kadaluarsa
                    if($transaksis->created_at <= $time){
                        $transaksis->update([
                                'status'=>2,
                                'note'=>'Transaksi Kadaluarsa'
                            ]);
                        if(!empty($transaksis->tagihan_id)){
                            $tagihan = Tagihan::where('tagihan_id',$transaksis->tagihan_id)->update([
                                'status'=>3,
                                'expired'=>0
                                ]);
                        }
                        
                        $tmp->delete;
                    }
                    
                    $check = Pulsa::history_trx_detail($tmp->transaksi->order_id);
                    
                    $user = User::where('id',$transaksis->user_id)->first();
                    $hargaproduk = $transaksis->total;

                    if($check->success == true){
                        $data = $check->data;
                        if($data->trxid == $tmp->transaksi->order_id) {
                            if( $data->status == 1 ) {
                                $tmp->delete();
                                if( $transaksis->status == 0 && $transaksis->jenis_transaksi == 'otomatis')
                                {
                                    $transaksis->token  = $data->token;
                                    $transaksis->note   = $data->note;
                                    $transaksis->status = 1;
                                
                                    DB::table('temptransaksis')
                                    ->where('transaksi_id', $transaksis->order_id)
                                    ->delete();
                                    
                                    $loop = true;
                                     //PROSES BONUS REFERREAL
                                    if(!empty($user->referred_by))
                                    {
                                        $user_ref    = User::where('id',$user->referred_by)->first();
                                      
                                        do {
                                            if(empty($user_ref->referred_by)){
                                                $loop = false;
                                            }
                                            $bonus_saldo = intval($user_ref->saldo) + intval($user_ref->referral_markup);
                                            
                                            $user_ref->update([
                                                'saldo'=>$bonus_saldo,
                                            ]);

                                            DB::table('mutasis_komisi')
                                                ->insert([
                                                    'user_id'=>$user_ref->id,
                                                    'from_reff_id'=>$user->id,
                                                    'komisi'=>$user_ref->referral_markup,
                                                    'jenis_komisi'=>2,
                                                    'note'=>'Trx '.$data->code,
                                                    'created_at'=>date('Y-m-d H:i:s'),
                                                    'updated_at'=>date('Y-m-d H:i:s'),
                                                ]);

                                            $mutasi_bonus = new Mutasi();
                                            $mutasi_bonus->user_id = $user_ref->id;
                                            $mutasi_bonus->trxid   = $transaksis->order_id;
                                            $mutasi_bonus->type    = 'credit';
                                            $mutasi_bonus->nominal = $user_ref->referral_markup;
                                            $mutasi_bonus->saldo   = intval($user_ref->saldo) + intval($user_ref->referral_markup);
                                            $mutasi_bonus->note    = "TRANSAKSI DOWNLINE (".$user->name.", #".$data->api_trxid.")";
                                            $mutasi_bonus->save();
                                            
                                            $bonus_komisi = Setting::settingsBonus(1);
                                            
                                            $bonus_saldo_trx = intval($user_ref->saldo) + intval($bonus_komisi);
                                            
                                            $user_ref->update([
                                                'saldo'=>$bonus_saldo_trx    
                                            ]);
                                            
                                             DB::table('mutasis_komisi')
                                                 ->insert([
                                                      'user_id'      => $user_ref->id,
                                                      'from_reff_id' => $user->id,
                                                      'komisi'       => $bonus_komisi,
                                                      'jenis_komisi' => 1,
                                                      'note'         => "Trx ".$data->code,
                                                      'created_at'   => date('Y-m-d H:i:s'),
                                                      'updated_at'   => date('Y-m-d H:i:s'),
                                                    ]);
        
                                            $mutasiRewardReff = new Mutasi();
                                            $mutasiRewardReff->user_id = $user_ref->id;
                                            $mutasiRewardReff->trxid = $transaksis->order_id;
                                            $mutasiRewardReff->type = 'credit';
                                            $mutasiRewardReff->nominal = $bonus_komisi;
                                            $mutasiRewardReff->saldo  = intval($user_ref->saldo) + intval($bonus_komisi);
                                            $mutasiRewardReff->note  = "BONUS TRANSAKSI REFERRAL (".$user->name.", #".$data->trxid_api.")";
                                            $mutasiRewardReff->save();
                                            
                                            $user_ref    = User::where('id',$user_ref->referred_by)->first();
                                        }
                                        while($loop);
                                       
                                    }
                                }
                            } elseif( ($data->status == '2') || ($data->status == '3') ) {
                                $tmp->delete();
                                if( $transaksis->status == 0 ) {
                                    $sisaSaldo = $user->saldo + $hargaproduk;
                                    $user->saldo = $sisaSaldo;
                                    $transaksis->note =$data->note;
                                    $transaksis->saldo_after_trx = $transaksis->saldo_before_trx;
                                    $transaksis->status = 2;
                                    
                                    if(!empty($transaksis->tagihan_id)){
                                        $tagihan = Tagihan::where('tagihan_id',$transaksis->tagihan_id)->update([
                                            'status'=>3,
                                            'expired'=>0
                                        ]);   
                                    }
                                    
                                    $mutasi = new Mutasi();
                                    $mutasi->user_id = $user->id;
                                    $mutasi->trxid = $transaksis->id;
                                    $mutasi->type = 'credit';
                                    $mutasi->nominal = $hargaproduk;
                                    $mutasi->saldo  = $sisaSaldo;
                                    $mutasi->note  = (($data->mtrpln != '-') ? 'TRANSAKSI '.$data->code.' '.$data->mtrpln.' GAGAL' : 'TRANSAKSI '.$data->code.' '.$data->target.' GAGAL');
                                    $mutasi->save();
                                }
                            }
                        }
                    }
                    
                    $user->save();
                    $transaksis->save();
                }
            }
            DB::commit();   
            $this->info('Succesfully Cek All Transaction');
        } catch (\Exception $e) {
         \Log::error($e);
          DB::rollback();
          dd($e);
        }    
    }
}
