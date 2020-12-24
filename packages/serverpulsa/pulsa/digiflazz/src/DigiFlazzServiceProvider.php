<?php
namespace Serverpulsa\Pulsa\DigiFlazz;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class DigiFlazzServiceProvider extends ServiceProvider
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
        App::bind('DigiFlazz', function()
        {
            return new DigiFlazz;
        });
    }
}
