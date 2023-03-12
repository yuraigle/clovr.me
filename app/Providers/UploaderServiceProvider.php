<?php

namespace App\Providers;

use App\Services\UploaderService;
use Illuminate\Support\ServiceProvider;

class UploaderServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(UploaderService::class, function () {
            return new UploaderService();
        });
    }
}
