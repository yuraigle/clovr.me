<?php

namespace App\Providers;

use App\Services\RecommendationsService;
use Illuminate\Support\ServiceProvider;

class RecommendationsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(RecommendationsService::class, function () {
            return new RecommendationsService();
        });
    }
}
