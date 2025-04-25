<?php

namespace Src\Auth\Application\DTO;

readonly class VerifyTokenDTO
{
    public function __construct(
        private string $authToken
    ) {}

    public function getAuthToken(): string
    {
        return $this->authToken;
    }
}
