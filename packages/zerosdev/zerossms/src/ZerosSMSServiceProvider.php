<?php

namespace ZerosDev\ZerosSMS;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ZerosSMSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('ZerosSMS', function() {
            return new ZerosSMS;
        });
    }
}
