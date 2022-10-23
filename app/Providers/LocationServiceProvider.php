<?php

namespace App\Providers;

use App\Services\LocationService;
use Illuminate\Support\ServiceProvider;

class LocationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(LocationService::class, function ($app) {
            return new LocationService($app->request);
        });
    }
}
