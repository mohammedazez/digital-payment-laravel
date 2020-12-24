<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Pulsa, DB,DigiFlazz;
use App\AppModel\Setting;
use Carbon\Carbon;
use Log;
class CekSaldo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saldo:cek';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'FOR CHECKING SALDO';

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
        $cek = Pulsa::cek_saldo();
       
        $status_server = Setting::first();
        if( $cek->success === true )
        {
            $status_server->saldo = $cek->data;
            $status_server->save();
        }
        
    }
}