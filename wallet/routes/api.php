<?php

use App\Http\Controllers\Api\{
    CardController,
    AccountController,
    CurrencyController,
    CardTypeController,
    TransactionController,
    CardProviderController,
    TransactionDepositController,
    TransactionWithdrawalController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {

    Route::middleware(['auth.token.validate'])->group(function () {

        Route::get('currency', [CurrencyController::class, 'index']);

        Route::get('card-type', [CardTypeController::class, 'index']);

        Route::get('card-provider', [CardProviderController::class, 'index']);

        Route::post('account', [AccountController::class, 'store']);
        Route::get('account/{account}', [AccountController::class, 'show']);
        Route::get('account/', [AccountController::class, 'index']);
        Route::delete('account/{account}', [AccountController::class, 'destroy']);

        Route::post('card', [CardController::class, 'store']);
        Route::get('card/{card}', [CardController::class, 'show']);
        Route::get('card', [CardController::class, 'index']);
        Route::delete('card/{card}', [CardController::class, 'destroy']);

        Route::post('transaction-deposit', [TransactionDepositController::class, 'store']);
        Route::post('transaction-withdraw', [TransactionWithdrawalController::class, 'store']);
    });

    Route::post('transaction-complete', [TransactionController::class, 'complete']);

});

