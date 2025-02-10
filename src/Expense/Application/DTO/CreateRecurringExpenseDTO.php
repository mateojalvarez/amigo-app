<?php

namespace Src\Expense\Application\DTO;

readonly class CreateRecurringExpenseDTO
{
    public function __construct(
        private AuthUserDTO $authUser,
        private ExpenseParticipantsListDTO $payers,
        private ExpenseParticipantsListDTO $payees,
        private float $totalAmount,
        private int $currencyId,
        private string $description,
        private string $startDate,
        private int $recurringTypeId,
        private int $intervals,
        private ?int $categoryId = null,
    ) {}

    public function getAuthUser(): AuthUserDTO
    {
        return $this->authUser;
    }

    public function getPayers(): ExpenseParticipantsListDTO
    {
        return $this->payers;
    }

    public function getPayees(): ExpenseParticipantsListDTO
    {
        return $this->payees;
    }

    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    public function getCurrencyId(): int
    {
        return $this->currencyId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function getRecurringTypeId(): int
    {
        return $this->recurringTypeId;
    }

    public function getIntervals(): int
    {
        return $this->intervals;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }
}
