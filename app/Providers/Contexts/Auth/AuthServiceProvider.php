<?php

namespace App\Providers\Contexts\Auth;

use Illuminate\Support\ServiceProvider;
use Src\Auth\Domain\Repositories\PersonalAccessTokenRepository;
use Src\Auth\Domain\Repositories\TwoFactorAuthRepository;
use Src\Auth\Domain\Repositories\UserRepository;
use Src\Auth\Infrastructure\Database\Repositories\PersonalAccessTokenEloquentRepository;
use Src\Auth\Infrastructure\Database\Repositories\TwoFactorAuthEloquentRepository;
use Src\Auth\Infrastructure\Database\Repositories\UserEloquentRepository;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepository::class, UserEloquentRepository::class);
        $this->app->bind(PersonalAccessTokenRepository::class, PersonalAccessTokenEloquentRepository::class);
        $this->app->bind(TwoFactorAuthRepository::class, TwoFactorAuthEloquentRepository::class);
    }
}
