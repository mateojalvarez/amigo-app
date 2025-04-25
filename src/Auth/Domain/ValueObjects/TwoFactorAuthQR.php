<?php

namespace Src\Auth\Domain\ValueObjects;

readonly class TwoFactorAuthQR
{
    public function __construct(
        private string $value
    ) {}

    public function value(): string
    {
        return $this->value;
    }
}
