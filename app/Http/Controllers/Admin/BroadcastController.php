<?php

namespace App\Http\Controllers\Admin;

use Response, Mail, Validator;
use App\User;
use Auth;
use App\Jobs\QueueBroadcastSMS;
use App\Jobs\QueueBroadcastEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppModel\SMSGateway;
use App\AppModel\Setting;

class BroadcastController extends Controller
{
    public function indexSMS()
    {
        return view('admin.broadcast.sms');
    }
    
    public function checkSMS(Request $request)
    {
        $phone = $request->phone;
        $isi = "TEST";
        $checkSMS = SMSGateway::send($phone, $isi);
        return Response::json(
            (array) $checkSMS
        );
    }
    
    public function sendBroadcastSMS(Request $request)
    {
        $isi = $request->isi;
        $users = User::where('status', 1)->get()->all();
        foreach($users as $user){
            $pesan = str_replace("[name]", $user->name, $isi);
            $phone = $user->phone;
            $job = (new QueueBroadcastSMS($phone, $pesan));
            dispatch($job);
        }
        return redirect()->back()->with('alert-success', 'Berhasil Mengirim Broadcast SMS');
    }
    
    public function indexEmail()
    {
        return view('admin.broadcast.email');
    }
    
    public function testEmail(Request $request)
    {
        $subject = "TEST";
        $isi = "Test Broadcast Email";
        $config_email = Setting::first();
        $v = Validator::make($request->all(), [
                'email' => ['required', 'email']
            ]);
        
        if( $v->fails() ) {
            return Response::json([
                'success' => false,
                'subject' => $subject,
                'body'    => $isi,
                'message' => $v->errors()->first()
            ]);
        }
            
        $email = $request->email;
        
        try
        {
            Mail::send([], [], function($m) use ($config_email,$email, $subject, $isi) {
                $m->from($config_email->email,$config_email->nama_sistem)
                    ->to($email)
                    ->subject($subject)
                    ->setBody($isi, 'text/html');
            });
            
            return Response::json([
                'success' => true,
                'subject' => $subject,
                'body'    => $isi,
                'message' => 'Email terkirim'
            ]);
        }
        catch(\Exception $e)
        {
            return Response::json([
                'success' => false,
                'subject' => $subject,
                'body'    => $isi,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function sendBroadcastEmail(Request $request)
    {
        $isi = $request->isi;
        $subject = $request->subject;
        $users = User::where('status', 1)->get()->all();
        foreach($users as $user) {
            $pesan = str_replace("[name]", $user->name, $isi);
            $email = $user->email;
            $job = (new QueueBroadcastEmail($email, $subject, $pesan));
            dispatch($job);
        }
        return redirect()->back()->with('alert-success', 'Berhasil Mengirim Broadcast Email');
    }
}