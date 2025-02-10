<?php

namespace Src\Expense\Domain\Repositories;

use Src\Expense\Domain\Entities\Lists\ExpenseList;
use Src\Expense\Domain\Entities\RecurringExpenseEntity;
use Src\Expense\Domain\ValueObjects\ExpenseListIdentifier;
use Src\Expense\Domain\ValueObjects\RecurringExpenseInterval;

interface RecurringExpenseRepository
{
    public function save(RecurringExpenseEntity $recurringExpenseEntity): void;

    public function saveInterval(RecurringExpenseInterval $interval): void;

    public function getList(ExpenseListIdentifier $identifier): ExpenseList;
}
