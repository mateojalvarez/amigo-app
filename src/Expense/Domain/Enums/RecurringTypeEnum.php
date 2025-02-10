<?php

namespace Src\Expense\Domain\Enums;

enum RecurringTypeEnum: int
{
    case DAILY   = 1;
    case WEEKLY  = 2;
    case MONTHLY = 3;
    case YEARLY  = 4;
}
