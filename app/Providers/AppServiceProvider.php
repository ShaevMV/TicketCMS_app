<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Ticket\Auth\Domain\Authenticate\AuthRepository;
use Ticket\Auth\Domain\Token\TokenRepository;
use Ticket\Auth\Infrastructure\Persistence\InMemoryTokenRepository;
use Ticket\User\Domain\UserRepository;
use Ticket\User\Infrastructure\Persistence\InMemoryUserRepository;

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
        $this->app->bind(TokenRepository::class, InMemoryTokenRepository::class);

        $this->app->bind(UserRepository::class, InMemoryUserRepository::class);
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
