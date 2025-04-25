<?php

namespace Src\Expense\Domain\Factories;

use Carbon\Carbon;
use Src\Expense\Application\DTO\CreateRecurringExpenseDTO;
use Src\Expense\Application\DTO\ExpenseParticipantsListDTO;
use Src\Expense\Domain\Entities\RecurringExpenseEntity;
use Src\Expense\Domain\Enums\RecurringTypeEnum;
use Src\Expense\Domain\Exceptions\InvalidDescriptionLengthException;
use Src\Expense\Domain\ValueObjects\ExpenseDescription;
use Src\Expense\Domain\ValueObjects\Lists\ParticipantsList;
use Src\Expense\Domain\ValueObjects\UserUuid;
use Src\Shared\Enums\CurrencyEnum;
use Src\Shared\ValueObjects\Amount;

class RecurringExpenseFactory
{
    /**
     * @throws InvalidDescriptionLengthException
     */
    public static function fromDTO(CreateRecurringExpenseDTO $dto): RecurringExpenseEntity
    {
        $recurringExpense = new RecurringExpenseEntity(
            self::getParticipantList($dto->getPayers()),
            self::getParticipantList($dto->getPayees()),
            self::getAmount($dto),
            Carbon::parse($dto->getStartDate()),
            new ExpenseDescription($dto->getDescription()),
            RecurringTypeEnum::from($dto->getRecurringTypeId()),
            $dto->getIntervals()
        );

        $recurringExpense->generateUuid();

        if ($dto->getCategoryId() !== null) {
            $recurringExpense->setCategory($dto->getCategoryId());
        }

        return $recurringExpense;
    }

    private static function getAmount(CreateRecurringExpenseDTO $dto): Amount
    {
        return new Amount(
            $dto->getTotalAmount(),
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
