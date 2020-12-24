<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB, Mail, Cekmutasi, Log;
use App\User;
use App\AppModel\SMSGateway;
use App\AppModel\Bank;
use App\AppModel\Deposit;
use App\AppModel\Mutasi;
use App\AppModel\Provider;
use Carbon\Carbon;

class CekDeposit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deposit:cek';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'FOR CHECKING DEPOSIT';

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
        try
        {
            $expired = Carbon::now()->subHours(24)->toDateTimeString();
            
            Deposit::where('status', 0)
                    ->where('expire', 1)
                    ->where('created_at', '<', $expired)
                    ->update([
                        'status'    => 2, // gagal
                        'expire'    => 0, // expired
                        'note'      => 'Deposit kadaluarsa silahkan request ulang atau hubungi Administrator jika sudah terlanjur melakukan pembayaran'
                    ]);
            
            // $deposits = Deposit::with('bank')
            //     ->whereHas('bank', function($bank) {
            //         $bank->whereIn('code', ['bri', 'bca', 'bni', 'mandiri_online', 'ovo', 'gopay']);
            //     })
            //     ->where('status', '=', 3)
            //     ->where('expire', '=', 1)
            //     ->take(100)->get();
 
            // foreach($deposits as $data_deposit)
            // {
            //     $banks = $data_deposit->bank;
                
            //     if($banks->code == 'ovo'){
            //         $mutasibank = Cekmutasi::ovo()->mutation([
            //         "account_number"    => preg_replace('/[^0-9]/', '', $banks->no_rek),
            //         "type"              => "credit",
            //         "amount"            => $data_deposit->nominal_trf,
            //         "date"              => array(
            //             "from"          => $data_deposit->created_at->setTimezone('Asia/Jakarta')->toDateTimeString(),
            //             "to"            => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString(),
            //             )
            //         ]);
            //     }
            //     else if($banks->code == 'gopay'){
            //         $mutasibank = Cekmutasi::gopay()->mutation([
            //         "account_number"    => preg_replace('/[^0-9]/', '', $banks->no_rek),
            //         "type"              => "credit",
            //         "amount"            => $data_deposit->nominal_trf,
            //         "date"              => array(
            //             "from"          => $data_deposit->created_at->setTimezone('Asia/Jakarta')->toDateTimeString(),
            //             "to"            => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString(),
            //             )
            //         ]);
            //     }else{
            //         $mutasibank = Cekmutasi::bank()->mutation([
            //         "service_code"      => $banks->code,
            //         "account_number"    => preg_replace('/[^0-9]/', '', $banks->no_rek),
            //         "type"              => "credit",
            //         "amount"            => $data_deposit->nominal_trf,
            //         "date"              => array(
            //             "from"          => $data_deposit->created_at->setTimezone('Asia/Jakarta')->toDateTimeString(),
            //             "to"            => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString(),
            //             )
            //         ]);   
            //     }
               
            //     if( $mutasibank->success === true && count($mutasibank->response) > 0 )
            //     {
            //         $amount = number_format($mutasibank->response[0]->amount, 0, "", "");
                    
            //         if( $amount == $data_deposit->nominal_trf )
            //         {
            //             DB::beginTransaction();
                        
            //             try
            //             {
            //                 $deposit = Deposit::findOrFail($data_deposit->id);
                            
            //                 $user = User::findOrFail($deposit->user_id);
            //                 $saldo = $user->saldo + $amount;
            //                 $user->saldo = $saldo;
            //                 $user->save();
                            
            //                 $deposit->status = 1;
            //                 $deposit->expire = 0;
            //                 $deposit->note = 'Deposit sebesar Rp '.number_format($deposit->nominal_trf, 0, '.', '.').' berhasil ditambahkan, saldo sekarang Rp '.number_format($saldo, 0, '.', '.').'.';
            //                 $deposit->save();
                            
            //                 $mutasi = new Mutasi();
            //                 $mutasi->user_id = $user->id;
            //                 $mutasi->trxid = $deposit->id;
            //                 $mutasi->type = 'credit';
            //                 $mutasi->nominal = $amount;
            //                 $mutasi->saldo  = $saldo;
            //                 $mutasi->note  = 'DEPOSIT/TOP-UP SALDO via '.$banks->nama_bank;
            //                 $mutasi->save();
                            
            //                 DB::commit();
            //             }
            //             catch(\Exception $e)
            //             {
            //                 DB::rollBack();
            //             }
            //         }
            //     }
            //     else
            //     {
            //         $a = strtotime($data_deposit->updated_at);
            //         if( time() >= ($a+(2*60*60)) )
            //         {
            //             $deposit = Deposit::findOrFail($data_deposit->id);
                        
            //             $deposit->status = 0;
            //             $deposit->expire = 1;
            //             $deposit->note = 'Pembayaran deposit dengan nominal ini belum ditemukan. Menunggu pembayaran sebesar Rp '.number_format($deposit->nominal_trf, 0, '.', '.');
            //             $deposit->save();
            //         }
            //     }
            // }
        }
        catch (\Exception $e)
        {
            Log::error($e);
        }
    }
}