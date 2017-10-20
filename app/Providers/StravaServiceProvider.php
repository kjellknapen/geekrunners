<?php

namespace App\Providers;
use NerdRunClub\Strava;
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
        $this->app->singleton('Strava', function ($app) {
            return new Strava(config('services.strava.client_id'), config('services.strava.client_secret'), config('services.strava.redirect_uri'));
        });
    }
}
