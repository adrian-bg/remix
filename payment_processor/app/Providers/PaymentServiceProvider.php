<?php

namespace App\Providers;

use App\Interfaces\Payable;
use App\Service\LocalPaymentService;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Payable::class, function ($app) {
            return new LocalPaymentService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
