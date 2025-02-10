<?php

namespace Src\Auth\Domain\ValueObjects;

readonly class Auth
{
    public function __construct(
        private AccessToken $accessToken,
        private RefreshToken $refreshToken,
        private User $user,
    ) {}

    public function getAccessToken(): AccessToken
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): RefreshToken
    {
        return $this->refreshToken;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
