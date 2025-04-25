<?php

namespace App\Providers\Contexts\User;

use Illuminate\Support\ServiceProvider;
use Src\User\Domain\Repositories\UserRepository;
use Src\User\Infrastructure\Database\Repositories\UserEloquentRepository;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepository::class, UserEloquentRepository::class);
    }
}
