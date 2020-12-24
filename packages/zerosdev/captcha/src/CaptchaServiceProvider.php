<?php

namespace ZerosDev\Captcha;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class CaptchaServiceProvider extends ServiceProvider
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
        App::bind('Captcha', function() {
            return new Captcha;
        });
    }
}