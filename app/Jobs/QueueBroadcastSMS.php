<?php

namespace App\Jobs;

use Freesms4Us;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\AppModel\SMSGateway;

class QueueBroadcastSMS implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    public $pesan;
    public $phone;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($phone, $pesan)
    {
        $this->pesan = $pesan;
        $this->phone = $phone;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SMSGateway::send($this->phone, $this->pesan);
    }
}
