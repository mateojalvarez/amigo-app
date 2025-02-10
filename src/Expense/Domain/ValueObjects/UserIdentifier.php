<?php

namespace Src\Expense\Domain\ValueObjects;

readonly class UserIdentifier
{
    public function __construct(
        private int $id,
        private UserUuid $uuid,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): UserUuid
    {
        return $this->uuid;
    }
}
