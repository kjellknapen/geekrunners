<?php

namespace App\Providers;

use App\StravaHandler;
use Illuminate\Support\ServiceProvider;

class StravaServiceProvider extends ServiceProvider
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
        $this->app->singleton(StravaHandler::class, function ($app) {
            return new StravaHandler();
        });
    }
}
