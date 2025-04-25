<?php

namespace Src\Auth\Domain\ValueObjects;

readonly class Token
{
    public function __construct(
        private string $value,
    ) {}

    public function getId(): int
    {
        [$id] = explode('|', $this->value, 1);

        return (int) $id;
    }

    public function getPlainValue(): string
    {
        return $this->value;
    }

    public function getHashedValue(): string
    {
        return hash('sha256', $this->value);
    }
}
