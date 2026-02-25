<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Interfaces\TicketRepositoryInterface::class,
            \App\Repositories\TicketRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\CustomerRepositoryInterface::class,
            \App\Repositories\CustomerRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
