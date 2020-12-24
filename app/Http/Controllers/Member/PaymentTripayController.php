<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppModel\Deposit;
use App\User;
use App\AppModel\Mutasi;
use App\AppModel\Provider;
use App\AppModel\SMSGateway;
use App\AppModel\Setting;
use DB,Exception;


class PaymentTripayController extends Controller
{
    public function callbackPaymentTripay(Request $request)
    {
        $setting = Setting::first();
        $provider = Provider::where('id','1')->firstOrFail();
        $privateKey = $provider->private_key;
        
        DB::beginTransaction();
        try
        {
            $json = $request->getContent();

            $callbackSignature = isset($_SERVER['HTTP_X_CALLBACK_SIGNATURE']) ? $_SERVER['HTTP_X_CALLBACK_SIGNATURE'] : '';
    
            $signature = hash_hmac('sha256',$json,$privateKey);
    
            if($callbackSignature !== $signature){
                exit("Invalid Signature");
            }
    
            $data = json_decode($json);
          
            $event = $_SERVER['HTTP_X_CALLBACK_EVENT'];
    
            if($event == 'payment_status')
            {
                if($data->status == 'PAID')
                {
                    $deposit = Deposit::find($data->merchant_ref);
                    
                    if($deposit->status != 0){
                        throw new Exception("Status deposit: ".$deposit->status);
                    }

                    if(!$deposit){
                        throw new Exception('Deposit not found');
                    }
                    
                    $user = User::find($deposit->user_id);
                    if(!$user){
                        throw new Exception('User not found');
                    }
                    
                    $saldo = $user->saldo + $deposit->nominal;
                    $user->saldo = $saldo;
                    $user->save();

                    $deposit->update([
                        'status'=>1,
                        'expire'=>0,
                        'note'=>'Deposit sebesar Rp '.number_format($deposit->nominal, 0, '.', '.').' berhasil ditambahkan, saldo sekarang Rp '.number_format($saldo, 0, '.', '.').'.',
                    ]);

                    $mutasi = new Mutasi();
                    $mutasi->user_id = $user->id;
                    $mutasi->trxid = $deposit->id;
                    $mutasi->type = 'credit';
                    $mutasi->nominal = $deposit->nominal;
                    $mutasi->saldo = $saldo;
                    $mutasi->note = 'DEPOSIT/TOP-UP SALDO via '.$deposit->bank->nama_bank;
                    $mutasi->save();

                    DB::commit();
                    
                    SMSGateway::send($user->phone, 'Yth. '.$user->name.', deposit Rp '.number_format($deposit->nominal, 0, '.', '.').' SUKSES via '.$deposit->bank->nama_bank.'. Saldo akhir: Rp '.number_format($saldo, 0, '.', '.').' ~ '.$setting->nama_sistem);
                }
                elseif($data->status == 'FAILED')
                {
                    $deposit = Deposit::find($data->merchant_ref);
                    
                    if(!$deposit){
                        throw new Exception('Deposit not found');
                    }
                    
                    $deposit->status = 2;
                    $deposit->expire = 0;
                    $deposit->note = $data->note;
                    $deposit->save();

                    DB::commit();
                }
            }
           
            echo json_encode(['success'=>true]);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return $e->getMessage();
        }
      
    }
}
