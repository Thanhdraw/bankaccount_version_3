<?php

namespace App\Providers;

use App\Repository\Eloquents\AccountRepository;
use App\Repository\Interfaces\AccountRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(AccountRepositoryInterface::class, AccountRepository::class);
    }
}