<?php

namespace Src\Balance\Application\DTO;

readonly class GetBalanceListDTO
{
    public function __construct(
        private string $userUuid
    ) {}

    public function getUserUuid(): string
    {
        return $this->userUuid;
    }
}
