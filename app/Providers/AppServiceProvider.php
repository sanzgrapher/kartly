<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Order\Contracts\OrderServiceInterface;
use App\Services\Order\OrderService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
