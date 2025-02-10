<?php

namespace Src\Auth\Application\DTO;

readonly class RefreshAuthDTO
{
    public function __construct(
        private string $refreshToken
    ) {}

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }
}
