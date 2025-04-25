<?php

namespace Src\Auth\Application\DTO;

readonly class CreateTwoFactorKeyDTO
{
    public function __construct(
        private int $userId,
        private string $userEmail,
        private string $appName
    ) {}

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function getAppName(): string
    {
        return $this->appName;
    }
}
