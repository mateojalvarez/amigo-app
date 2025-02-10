<?php

namespace Src\Expense\Application\DTO;

readonly class ExpenseParticipantsListDTO
{
    /**
     * @param array<string> $participantsUuids
     */
    public function __construct(
        private array $participantsUuids
    ) {}

    /**
     * @return string[]
     */
    public function getParticipantsUuids(): array
    {
        return $this->participantsUuids;
    }
}
