<?php

use Illuminate\Support\Facades\Route;
use Src\Auth\Infrastructure\Http\Controllers\CreateTwoFactorKeyController;
use Src\Auth\Infrastructure\Http\Controllers\VerifyTwoFactorCodeController;
use Src\Auth\Infrastructure\Http\Controllers\LoginController;
use Src\Auth\Infrastructure\Http\Controllers\LogoutController;
use Src\Auth\Infrastructure\Http\Controllers\RefreshAuthController;

Route::prefix('auth')->group(function () {
    Route::post('/login', LoginController::class);
    Route::post('/refresh', RefreshAuthController::class);
    Route::get('/2fa', CreateTwoFactorKeyController::class)->middleware('auth:sanctum');
    Route::post('/2fa/verify', VerifyTwoFactorCodeController::class)->middleware('auth:sanctum');
    Route::delete('/logout', LogoutController::class)->middleware('auth_verified');
});
