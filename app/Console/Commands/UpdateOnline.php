<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB, Exception;
use App\User;
use Carbon\Carbon;

class UpdateOnline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'online:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update online status';

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
            User::where('last_online', '<=', Carbon::now()->subMinutes(3)->toDateTimeString())
                ->where('online', 1)
                ->update([
                    'online'    => 0,
                    'last_online'   => Carbon::now()->toDateTimeString()
                    ]);
        }
        catch(Exception $e)
        {
            Log::error($e);
        }
    }
}