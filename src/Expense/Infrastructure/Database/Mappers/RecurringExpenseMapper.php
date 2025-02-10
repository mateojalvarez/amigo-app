<?php

namespace Src\Expense\Infrastructure\Database\Mappers;

use App\Models\RecurringExpense;
use Carbon\Carbon;
use Src\Expense\Domain\Entities\RecurringExpenseEntity;
use Src\Expense\Domain\Enums\RecurringTypeEnum;
use Src\Expense\Domain\Exceptions\InvalidDescriptionLengthException;
use Src\Expense\Domain\ValueObjects\ExpenseDescription;
use Src\Shared\Enums\CurrencyEnum;
use Src\Shared\ValueObjects\Amount;

class RecurringExpenseMapper
{
    /**
     * @throws InvalidDescriptionLengthException
     */
    public static function fromModelToEntity(RecurringExpense $model): RecurringExpenseEntity
    {
        $recurringExpense = new RecurringExpenseEntity(
            ParticipantListMapper::fromCollectionToList($model->payers),
            ParticipantListMapper::fromCollectionToList($model->payees),
            new Amount(
                $model->total_amount,
                CurrencyEnum::from($model->currency_id)
            ),
            Carbon::parse($model->start_date),
            ExpenseDescription::fromString($model->description),
            RecurringTypeEnum::from($model->recurring_type_id),
            $model->intervals,
        );

        $recurringExpense->setId($model->id);

        $recurringExpense->setUuid($model->uuid);

        if ($model->expense_category_id) {
            $recurringExpense->setCategory(
                $model->expense_category_id
            );
        }

        return $recurringExpense;
    }
}
