<?php

use App\Http\Controllers\V1\LoginController;
use App\Http\Controllers\V1\LogoutController;
use App\Http\Middleware\TokenValidationMiddleware;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    Route::controller(LoginController::class)->group(function () {
        Route::post('/login', 'login');
    });

    Route::controller(LogoutController::class)->middleware(TokenValidationMiddleware::class)->group(function () {
        Route::post('/logout', 'logout');
    });

});

