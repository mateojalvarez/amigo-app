<?php

namespace Src\Expense\Domain\ValueObjects;

use Src\Expense\Domain\Exceptions\InvalidNoteLengthException;

readonly class ExpenseNote
{
    /**
     * @throws InvalidNoteLengthException
     */
    public function __construct(
        private string $value,
        private UserIdentifier $userIdentifier
    ) {
        $this->validate();
    }

    public function value(): string
    {
        return $this->value;
    }

    public function userIdentifier(): UserIdentifier
    {
        return $this->userIdentifier;
    }

    /**
     * @throws InvalidNoteLengthException
     */
    private function validate(): void
    {
        if (strlen($this->value) > 255) {
            throw new InvalidNoteLengthException();
        }
    }
}
