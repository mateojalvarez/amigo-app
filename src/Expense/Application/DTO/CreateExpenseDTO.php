<?php

namespace Src\Expense\Application\DTO;

readonly class CreateExpenseDTO
{
    public function __construct(
        private AuthUserDTO $authUser,
        private ExpenseParticipantsListDTO $payers,
        private ExpenseParticipantsListDTO $payees,
        private float $amount,
        private int $currencyId,
        private string $description,
        private string $paymentDate,
        private ?int $categoryId = null,
        private ?string $note = null,
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

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrencyId(): int
    {
        return $this->currencyId;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPaymentDate(): string
    {
        return $this->paymentDate;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }
}
