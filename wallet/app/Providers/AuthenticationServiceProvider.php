<?php

namespace App\Providers;

use App\Interfaces\Authenticatable;
use Carbon\Laravel\ServiceProvider;
use App\Services\Authentication\AuthenticatorService;

class AuthenticationServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Authenticatable::class, function ($app) {
            return new AuthenticatorService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
