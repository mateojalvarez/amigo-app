<?php

namespace Src\Expense\Infrastructure\Database\Mappers;

use App\Models\ExpensePayee;
use App\Models\ExpensePayer;
use App\Models\RecurringExpensePayee;
use App\Models\RecurringExpensePayer;
use Illuminate\Support\Collection;
use Src\Expense\Domain\ValueObjects\Lists\ParticipantsList;

class ParticipantListMapper
{
    /**
     * @param Collection<int,ExpensePayee>|Collection<int,ExpensePayer>|Collection<int,RecurringExpensePayee>|Collection<int,RecurringExpensePayer> $collection
     */
    public static function fromCollectionToList(Collection $collection): ParticipantsList
    {
        $participantList = new ParticipantsList();

        foreach ($collection as $participant) {
            if ($user = $participant->user) {
                $participantList->addParticipant(
                    ParticipantMapper::fromModelToVO($user)
                );
            }
        }

        return $participantList;
    }
}
