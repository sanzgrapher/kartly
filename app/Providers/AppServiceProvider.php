<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Order\Contracts\OrderServiceInterface;
use App\Services\Order\OrderService;
use App\Services\Mail\Contracts\MailServiceInterface;
use App\Services\Mail\MailService;
use App\Services\Products\Contracts\RecommendationServiceInterface;
use App\Services\Products\RecommendationService;
use App\Services\ML\MLRecommendationEngine;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        $this->app->bind(MailServiceInterface::class, MailService::class);

        // ML Recommendation Services
        $this->app->singleton(MLRecommendationEngine::class);
        $this->app->bind(RecommendationServiceInterface::class, RecommendationService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
