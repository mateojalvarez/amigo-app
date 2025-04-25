<?php

namespace Src\User\Application\DTO;

readonly class GetUserDTO
{
    public function __construct(
        private int $userId
    ) {}

    public function getUserId(): int
    {
        return $this->userId;
    }
}
