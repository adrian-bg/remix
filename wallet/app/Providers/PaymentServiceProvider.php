<?php

namespace App\Providers;

use App\Interfaces\HasPayments;
use Carbon\Laravel\ServiceProvider;
use App\Services\Transaction\PaymentService;

class PaymentServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(HasPayments::class, function ($app) {
            return new PaymentService();
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
