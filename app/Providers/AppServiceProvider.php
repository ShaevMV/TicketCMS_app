<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Ticket\Auth\Domain\Authenticate\AuthRepository;
use Ticket\Auth\Infrastructure\Persistence\InMemoryTokenRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }
        $this->app->bind(AuthRepository::class, InMemoryTokenRepository::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
