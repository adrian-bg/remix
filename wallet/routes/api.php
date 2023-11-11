<?php

use App\Http\Controllers\Api\{
    AccountController
};
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ValidateAuthToken;
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

        Route::post('account', [AccountController::class, 'store']);
        Route::get('account/{account}', [AccountController::class, 'show']);
        Route::get('account/', [AccountController::class, 'index']);

    });

});

