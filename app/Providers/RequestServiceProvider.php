<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use NerdRunClub\Request;

class RequestServiceProvider extends ServiceProvider
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
        $this->app->singleton('Request', function ($app) {
            return new Request();
        });
    }
}
