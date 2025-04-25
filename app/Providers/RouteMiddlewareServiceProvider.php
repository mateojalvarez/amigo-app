<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\ServiceProvider;
use Src\Auth\Infrastructure\Http\Middlewares\EnsureTokenIsVerified;

class RouteMiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {}

    public function boot(): void
    {
        Route::aliasMiddleware('verified_token', EnsureTokenIsVerified::class);

        Route::middlewareGroup('auth_verified', [
            'auth:sanctum',
            'verified_token',
        ]);
    }
}
