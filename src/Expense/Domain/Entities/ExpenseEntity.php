<?php

namespace Src\Expense\Domain\Entities;

use Carbon\Carbon;
use Src\Expense\Domain\Enums\ExpenseCategoryEnum;
use Src\Expense\Domain\Exceptions\InvalidNoteLengthException;
use Src\Expense\Domain\ValueObjects\ExpenseDescription;
use Src\Expense\Domain\ValueObjects\ExpenseNote;
use Src\Expense\Domain\ValueObjects\Lists\ParticipantsList;
use Src\Expense\Domain\ValueObjects\UserIdentifier;
use Src\Shared\ValueObjects\Amount;

class ExpenseEntity
{
    private int $id;
    private string $uuid;
    private ?ExpenseCategoryEnum $category = null;
    private ?ExpenseNote $note             = null;

    public function __construct(
        private readonly ParticipantsList $payers,
        private readonly ParticipantsList $payees,
        private readonly Amount $amount,
        private readonly Carbon $expenseDate,
        private readonly ExpenseDescription $description
    ) {}

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getPayers(): ParticipantsList
    {
        return $this->payers;
    }

    public function getPayees(): ParticipantsList
    {
        return $this->payees;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getExpenseDate(): Carbon
    {
        return $this->expenseDate;
    }

    public function getDescription(): ExpenseDescription
    {
        return $this->description;
    }

    public function getCategory(): ?ExpenseCategoryEnum
    {
        return $this->category;
    }

    public function setCategory(int $categoryId): void
    {
        $this->category = ExpenseCategoryEnum::from($categoryId);
    }

    public function getNote(): ?ExpenseNote
    {
        return $this->note;
    }

    /**
     * @throws InvalidNoteLengthException
     */
    public function setNote(string $note, UserIdentifier $userIdentifier): void
    {
        $this->note = new ExpenseNote($note, $userIdentifier);
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function generateUuid(): void
    {
        $this->uuid = uniqid(more_entropy: true);
    }
}
