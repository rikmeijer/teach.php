<?php

namespace App\Providers;

use App\Avans\Rooster;
use ICal;
use Illuminate\Support\ServiceProvider;

class AvansRoosterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Avans/Rooster',
            function ($app) {
                return new Rooster(new ICal());
            }
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
