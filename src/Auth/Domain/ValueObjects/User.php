<?php

namespace Src\Auth\Domain\ValueObjects;

readonly class User
{
    public function __construct(
        private int $id,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
}
