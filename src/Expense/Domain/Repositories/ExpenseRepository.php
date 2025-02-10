<?php

namespace Src\Expense\Domain\Repositories;

use Src\Expense\Domain\Entities\ExpenseEntity;
use Src\Expense\Domain\Entities\Lists\ExpenseList;
use Src\Expense\Domain\ValueObjects\ExpenseListIdentifier;

interface ExpenseRepository
{
    public function save(ExpenseEntity $expenseEntity): void;

    public function getExpenseList(ExpenseListIdentifier $identifier): ExpenseList;
}
