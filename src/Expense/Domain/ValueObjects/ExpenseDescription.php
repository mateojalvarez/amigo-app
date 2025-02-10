<?php

namespace Src\Expense\Domain\ValueObjects;

use Src\Expense\Domain\Exceptions\InvalidDescriptionLengthException;

readonly class ExpenseDescription
{
    /**
     * @throws InvalidDescriptionLengthException
     */
    public function __construct(
        private string $value
    ) {
        $this->validate();
    }

    /**
     * @throws InvalidDescriptionLengthException
     */
    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    /**
     * @throws InvalidDescriptionLengthException
     */
    private function validate(): void
    {
        if (strlen($this->value) > 50) {
            throw new InvalidDescriptionLengthException();
        }
    }
}
