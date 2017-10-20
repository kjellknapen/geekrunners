<?php

namespace App\Providers;

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
        $this->app->singleton(\NerdRunClub\Strava::class, function ($app) {
            return new \NerdRunClub\Strava();
        });
    }
}
