<?php

namespace Src\Shared\ValueObjects;

readonly class Email
{
    public function __construct(
        private string $value
    ) {}

    public function value(): string
    {
        return $this->value;
    }
}
