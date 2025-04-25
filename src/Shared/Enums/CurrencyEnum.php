<?php

namespace Src\Shared\Enums;

enum CurrencyEnum: int
{
    case ARS = 32;
    case USD = 840;
    case UYU = 858;
    case EUR = 978;
    case GBP = 826;
    case CAD = 124;
    case AUD = 36;
    case JPY = 392;
    case MXN = 484;
    case HKD = 344;
    case CNY = 156;

    public function equals(CurrencyEnum $currencyEnum): bool
    {
        return $this->value === $currencyEnum->value;
    }
}
