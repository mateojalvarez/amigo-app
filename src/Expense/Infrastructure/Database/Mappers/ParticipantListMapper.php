<?php

namespace Src\Expense\Infrastructure\Database\Mappers;

use App\Models\ExpensePayee;
use App\Models\ExpensePayer;
use Illuminate\Support\Collection;
use Src\Expense\Domain\ValueObjects\Lists\ParticipantsList;

class ParticipantListMapper
{
    /**
     * @param Collection<int, ExpensePayee|ExpensePayer> $collection
     */
    public static function fromCollectionToList(Collection $collection): ParticipantsList
    {
        $participantList = new ParticipantsList();

        foreach ($collection as $participant) {
            $participantList->addParticipant(
                ParticipantMapper::fromModelToVO($participant->user)
            );
        }

        return $participantList;
    }
}
