<?php

namespace Src\Auth\Domain\Repositories;

use Src\Auth\Domain\ValueObjects\Auth;
use Src\Auth\Domain\ValueObjects\Credentials;
use Src\Auth\Domain\ValueObjects\RefreshToken;
use Src\Auth\Domain\ValueObjects\User;

interface UserRepository
{
    public function login(Credentials $credentials): Auth;

    public function refreshToken(RefreshToken $refreshToken): Auth;

    public function logout(User $user): void;
}
