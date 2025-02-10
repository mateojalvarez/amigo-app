<?php

namespace Src\Expense\Application\DTO;

readonly class AuthUserDTO
{
    public function __construct(
        private int $id,
        private string $uuid
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
