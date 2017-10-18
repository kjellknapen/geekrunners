<?php

namespace App\Providers;

use App\NerdRunClub\Strava;
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
        $this->app->singleton(Strava::class, function ($app) {
            return new Strava();
        });
    }
}
