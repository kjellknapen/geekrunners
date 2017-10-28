<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use NerdRunClub\Calculation;

class CalculationServiceProvider extends ServiceProvider
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
        $this->app->singleton('Calculation', function ($app) {
            return new Calculation();
        });
    }
}
