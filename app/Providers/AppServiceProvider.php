<?php

namespace App\Providers;

use App\Domain\Product\ProductRepository;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\Eloquent\Product\EloquentProductRepository;
use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Persistence\Eloquent\User\EloquentUserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class,EloquentUserRepository::class);
        $this->app->bind(ProductRepository::class,EloquentProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
