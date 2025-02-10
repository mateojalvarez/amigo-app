<?php

namespace Src\Expense\Domain\ValueObjects;

readonly class GroupUuid
{
    public function __construct(
        private string $value
    ) {}

    public function value(): string
    {
        return $this->value;
    }
}
