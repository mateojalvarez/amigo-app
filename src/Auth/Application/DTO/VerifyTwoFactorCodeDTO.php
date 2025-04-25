<?php

namespace Src\Auth\Application\DTO;

readonly class VerifyTwoFactorCodeDTO
{
    public function __construct(
        private int $userId,
        private string $authToken,
        private string $twoFactorCode
    ) {}

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    public function getTwoFactorCode(): string
    {
        return $this->twoFactorCode;
    }
}
