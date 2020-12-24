<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\AppModel\Setting;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $users;
    public $setting;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($users)
    {
        $this->users = $users;
        $this->setting = Setting::first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->setting->email, $this->setting->nama_sistem)
        ->subject('Selamat Datang di '.$this->setting->nama_sistem)
        ->view('emails.welcome');
    }
}
