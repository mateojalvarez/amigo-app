<?php

use Src\User\Infrastructure\Http\Controllers\CreateUserController;
use Src\User\Infrastructure\Http\Controllers\GetUserController;

Route::prefix('user')->group(function () {
    Route::post('', CreateUserController::class);
    Route::get('', GetUserController::class)->middleware('auth_verified');
});
