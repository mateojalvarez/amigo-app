<?php

namespace Src\Expense\Domain\Entities;

use Carbon\Carbon;
use Src\Expense\Domain\Enums\ExpenseCategoryEnum;
use Src\Expense\Domain\Enums\RecurringTypeEnum;
use Src\Expense\Domain\ValueObjects\ExpenseDescription;
use Src\Expense\Domain\ValueObjects\Lists\ParticipantsList;
use Src\Shared\ValueObjects\Amount;

class RecurringExpenseEntity
{
    private int $id;
    private string $uuid;
    private ?ExpenseCategoryEnum $category = null;

    public function __construct(
        readonly private ParticipantsList $payers,
        readonly private ParticipantsList $payees,
        readonly private Amount $totalAmount,
        readonly private Carbon $startDate,
        readonly private ExpenseDescription $description,
        readonly private RecurringTypeEnum $recurringType,
        readonly private int $totalIntervals,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
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

    public function getTotalAmount(): Amount
    {
        return $this->totalAmount;
    }

    public function getStartDate(): Carbon
    {
        return $this->startDate;
    }

    public function getDescription(): ExpenseDescription
    {
        return $this->description;
    }

    public function getRecurringType(): RecurringTypeEnum
    {
        return $this->recurringType;
    }

    public function getTotalIntervals(): int
    {
        return $this->totalIntervals;
    }

    public function getCategory(): ?ExpenseCategoryEnum
    {
        return $this->category;
    }

    public function setCategory(int $categoryId): void
    {
        $this->category = ExpenseCategoryEnum::from($categoryId);
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
