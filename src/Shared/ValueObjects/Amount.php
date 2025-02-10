<?php

namespace Src\Shared\ValueObjects;

use Src\Shared\Enums\CurrencyEnum;

readonly class Amount
{
    public function __construct(
        private float $value,
        private CurrencyEnum $currency
    ) {}

    public function getValue(): float
    {
        return $this->value;
    }

    public function getCurrency(): CurrencyEnum
    {
        return $this->currency;
    }
}
