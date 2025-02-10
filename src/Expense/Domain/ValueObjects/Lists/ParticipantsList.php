<?php

namespace Src\Expense\Domain\ValueObjects\Lists;

use Src\Expense\Domain\ValueObjects\UserUuid;

class ParticipantsList
{
    /**
     * @var array<UserUuid>
     */
    private array $participants;

    /**
     * @param array<UserUuid> $participants
     */
    public function __construct(array $participants = [])
    {
        $this->participants = $participants;
    }

    /**
     * @return array<UserUuid>
     */
    public function getParticipants(): array
    {
        return $this->participants;
    }

    public function addParticipant(UserUuid $participant): void
    {
        $this->participants[] = $participant;
    }

    public function count(): int
    {
        return count($this->participants);
    }
}
