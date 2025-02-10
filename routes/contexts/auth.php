<?php

use Illuminate\Support\Facades\Route;
use Src\Auth\Infrastructure\Http\Controllers\LoginController;
use Src\Auth\Infrastructure\Http\Controllers\RefreshAuthController;
use Src\Auth\Infrastructure\Http\Controllers\LogoutController;

Route::prefix('auth')->group(function () {
    Route::post('/login', LoginController::class);
    Route::post('/refresh', RefreshAuthController::class);
    Route::delete('/logout', LogoutController::class)->middleware('auth:sanctum');
});
