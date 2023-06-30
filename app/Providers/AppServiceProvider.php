<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            \App\Restaurant\Domain\Repositories\RestaurantRepositoryInterface::class,
            \App\Restaurant\Domain\Repositories\HotpepperRestaurantRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
