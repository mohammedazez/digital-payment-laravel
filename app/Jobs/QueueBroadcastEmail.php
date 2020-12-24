<?php

namespace App\Jobs;

use Mail, Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\AppModel\Setting;

class QueueBroadcastEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    public $pesan;
    public $email;
    public $subject;
    public $setting;
    public $from_email;
    public $from_name;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $subject, $pesan)
    {
        $this->pesan = $pesan;
        $this->email = $email;
        $this->subject = $subject;
        $this->setting = Setting::first();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pesan      = $this->pesan;
        $email      = $this->email;
        $subject    = $this->subject;
        $from_mail  = $this->setting->email;
        $from_name  = $this->setting->nama_sistem;
        try
        {
            Mail::send([], [], function($mail) use ($from_mail,$from_name,$email, $subject, $pesan) {
                $mail->from($from_mail,$from_name)
                    ->to($email)
                    ->subject($subject)
                    ->setBody($pesan, 'text/html');
            });
        }
        catch(Exception $e)
        {
            $this->delete();
        }
    }
}