<?php

namespace Tripay\Pulsa;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class PulsaServiceProvider extends ServiceProvider
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
        App::bind('Pulsa', function() {
            return new Pulsa;
        });
    }
}