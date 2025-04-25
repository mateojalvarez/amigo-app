<?php

namespace Src\Shared\ValueObjects;

use Src\Shared\Enums\CurrencyEnum;

class Amount
{
    public function __construct(
        private float $value,
        private readonly CurrencyEnum $currency
    ) {}

    public function getValue(): float
    {
        return $this->value;
    }

    public function getCurrency(): CurrencyEnum
    {
        return $this->currency;
    }

    public function negateValue(): void
    {
        $this->value = -1 * $this->value;
    }
}
