<?php

namespace Src\Expense\Infrastructure\Database\Mappers;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Src\Expense\Domain\Entities\ExpenseEntity;
use Src\Expense\Domain\Exceptions\InvalidDescriptionLengthException;
use Src\Expense\Domain\Exceptions\InvalidNoteLengthException;
use Src\Expense\Domain\ValueObjects\ExpenseDescription;
use Src\Expense\Domain\ValueObjects\UserIdentifier;
use Src\Expense\Domain\ValueObjects\UserUuid;
use Src\Shared\Enums\CurrencyEnum;
use Src\Shared\ValueObjects\Amount;

class ExpenseMapper
{
    /**
     * @throws InvalidNoteLengthException
     * @throws InvalidDescriptionLengthException
     */
    public static function fromModelToEntity(Expense|Model $model): ExpenseEntity
    {
        $expense = new ExpenseEntity(
            ParticipantListMapper::fromCollectionToList($model->payers),
            ParticipantListMapper::fromCollectionToList($model->payees),
            new Amount(
                $model->amount,
                CurrencyEnum::from($model->currency_id)
            ),
            Carbon::parse($model->expense_date),
            ExpenseDescription::fromString($model->description)
        );

        $expense->setUuid($model->uuid);

        $expense->setId($model->id);

        if ($model->expense_category_id) {
            $expense->setCategory(
                $model->expense_category_id
            );
        }

        if ($note = $model->note) {
            $expense->setNote(
                $note->note,
                new UserIdentifier(
                    $note->user_id,
                    new UserUuid($note->user->uuid)
                )
            );
        }

        return $expense;
    }
}
