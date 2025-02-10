<?php

namespace App\Providers\Contexts\Auth;

use Illuminate\Support\ServiceProvider;
use Src\Auth\Domain\Repositories\UserRepository;
use Src\Auth\Infrastructure\Database\Repositories\UserEloquentRepository;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepository::class, UserEloquentRepository::class);
    }
}
