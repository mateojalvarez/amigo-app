<?php

namespace Src\Auth\Application\DTO;

readonly class LogoutDTO
{
    public function __construct(
        private int $userId
    ) {}

    public function getUserId(): int
    {
        return $this->userId;
    }
}
