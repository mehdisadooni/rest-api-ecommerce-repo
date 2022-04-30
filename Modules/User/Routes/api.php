<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \Modules\User\Http\Controllers\Api\V1\Auth\RegisterController;
use \Modules\User\Http\Controllers\Api\V1\Auth\LogoutController;
use \Modules\User\Http\Controllers\Api\V1\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::name('auth.')->group(function () {
        Route::middleware('guest')->group(function () {
            Route::post('/register', RegisterController::class)->name('register');
            Route::post('/login', LoginController::class)->name('login');
        });

        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
        });
    });
});
