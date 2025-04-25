<?php

namespace Src\Shared\Services\Balance\ValueObjects;

readonly class UserUuid
{
    public function __construct(
        private string $value
    ) {}

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
