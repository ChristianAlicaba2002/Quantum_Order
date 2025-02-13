<?php

namespace App\Providers;

use App\Domain\User\UserRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
