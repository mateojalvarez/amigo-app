<?php

namespace Src\Expense\Domain\Enums;

enum ExpenseCategoryEnum: int
{
    case FOOD          = 1;
    case TRANSPORT     = 2;
    case ACCOMMODATION = 3;
    case ENTERTAINMENT = 4;
    case OTHER         = 5;
}
