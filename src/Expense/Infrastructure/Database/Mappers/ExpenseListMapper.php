<?php

namespace Src\Expense\Infrastructure\Database\Mappers;

use App\Models\Expense;
use App\Models\RecurringExpense;
use Illuminate\Database\Eloquent\Collection;
use Src\Expense\Domain\Entities\Lists\ExpenseList;
use Src\Expense\Domain\Exceptions\InvalidDescriptionLengthException;
use Src\Expense\Domain\Exceptions\InvalidNoteLengthException;

class ExpenseListMapper
{
    /**
     * @param Collection<int, Expense|RecurringExpense> $collection
     *
     * @throws InvalidDescriptionLengthException
     * @throws InvalidNoteLengthException
     */
    public static function fromCollectionToList(Collection $collection): ExpenseList
    {
        $expenseList = new ExpenseList();

        foreach ($collection as $expense) {
            if ($expense instanceof RecurringExpense) {
                $expenseList->add(
                    RecurringExpenseMapper::fromModelToEntity($expense)
                );
                continue;
            }
            $expenseList->add(
                ExpenseMapper::fromModelToEntity($expense)
            );
        }

        return $expenseList;
    }
}
