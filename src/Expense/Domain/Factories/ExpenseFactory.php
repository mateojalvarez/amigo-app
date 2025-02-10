<?php

namespace Src\Expense\Domain\Factories;

use Carbon\Carbon;
use Src\Expense\Application\DTO\CreateExpenseDTO;
use Src\Expense\Application\DTO\ExpenseParticipantsListDTO;
use Src\Expense\Domain\Entities\ExpenseEntity;
use Src\Expense\Domain\Entities\RecurringExpenseEntity;
use Src\Expense\Domain\Exceptions\InvalidDescriptionLengthException;
use Src\Expense\Domain\Exceptions\InvalidNoteLengthException;
use Src\Expense\Domain\ValueObjects\ExpenseDescription;
use Src\Expense\Domain\ValueObjects\Lists\ParticipantsList;
use Src\Expense\Domain\ValueObjects\UserIdentifier;
use Src\Expense\Domain\ValueObjects\UserUuid;
use Src\Shared\Enums\CurrencyEnum;
use Src\Shared\ValueObjects\Amount;

class ExpenseFactory
{
    /**
     * @throws InvalidNoteLengthException
     * @throws InvalidDescriptionLengthException
     */
    public static function fromDTO(CreateExpenseDTO $dto): ExpenseEntity
    {
        $expense = new ExpenseEntity(
            self::getParticipantList($dto->getPayers()),
            self::getParticipantList($dto->getPayees()),
            self::getAmount($dto),
            Carbon::parse($dto->getPaymentDate()),
            new ExpenseDescription($dto->getDescription())
        );

        $expense->generateUuid();

        if ($dto->getCategoryId() !== null) {
            $expense->setCategory($dto->getCategoryId());
        }

        if ($dto->getNote() !== null) {
            $expense->setNote(
                $dto->getNote(),
                new UserIdentifier(
                    $dto->getAuthUser()->getId(),
                    new UserUuid($dto->getAuthUser()->getUuid())
                )
            );
        }

        return $expense;

    }

    public static function fromRecurringExpense(RecurringExpenseEntity $recurringExpense): ExpenseEntity
    {
        $expense = new ExpenseEntity(
            $recurringExpense->getPayers(),
            $recurringExpense->getPayees(),
            new Amount(
                $recurringExpense->getTotalAmount()->getValue() / $recurringExpense->getTotalIntervals(),
                $recurringExpense->getTotalAmount()->getCurrency()
            ),
            $recurringExpense->getStartDate(),
            $recurringExpense->getDescription()
        );

        if ($recurringExpense->getCategory() !== null) {
            $expense->setCategory($recurringExpense->getCategory()->value);
        }

        return $expense;
    }

    private static function getAmount(CreateExpenseDTO $dto): Amount
    {
        return new Amount(
            $dto->getAmount(),
            CurrencyEnum::from($dto->getCurrencyId())
        );
    }

    private static function getParticipantList(ExpenseParticipantsListDTO $participants): ParticipantsList
    {
        $participantsList = new ParticipantsList();
        foreach ($participants->getParticipantsUuids() as $participantUuid) {
            $participantsList->addParticipant(new UserUuid($participantUuid));
        }

        return $participantsList;
    }
}
