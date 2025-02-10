<?php

namespace Src\Expense\Domain\ValueObjects;

readonly class RecurringExpenseInterval
{
    public function __construct(
        private int $recurringExpenseId,
        private int $expenseId,
        private int $interval
    ) {}

    public function getRecurringExpenseId(): int
    {
        return $this->recurringExpenseId;
    }

    public function getExpenseId(): int
    {
        return $this->expenseId;
    }

    public function getInterval(): int
    {
        return $this->interval;
    }
}
