<?php

namespace Src\Expense\Domain\Entities\Lists;

use Src\Expense\Domain\Entities\ExpenseEntity;
use Src\Expense\Domain\Entities\RecurringExpenseEntity;

class ExpenseList
{
    /**
     * @var array<ExpenseEntity|RecurringExpenseEntity>
     */
    private array $expenses;

    /**
     * @param array<ExpenseEntity|RecurringExpenseEntity> $expenses
     */
    public function __construct(array $expenses = [])
    {
        $this->expenses = $expenses;
    }

    public function add(ExpenseEntity|RecurringExpenseEntity $expense): void
    {
        $this->expenses[] = $expense;
    }

    /**
     * @param array<ExpenseEntity|RecurringExpenseEntity> $expenses
     */
    public function merge(array $expenses): void
    {
        $this->expenses = array_merge($expenses, $this->expenses);
    }

    /**
     * @return array<ExpenseEntity|RecurringExpenseEntity>
     */
    public function getExpenses(): array
    {
        return $this->expenses;
    }
}
