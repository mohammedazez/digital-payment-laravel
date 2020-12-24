<?php

namespace Appnotif\Notif;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class NotifServiceProvider extends ServiceProvider
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
        App::bind('notif', function()
        {
            return new Notif;
        });
    }
}
