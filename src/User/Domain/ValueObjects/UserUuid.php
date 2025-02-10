<?php

namespace Src\User\Domain\ValueObjects;

readonly class UserUuid
{
    public function __construct(
        private string $value
    ) {}

    public function value(): string
    {
        return $this->value;
    }
}
