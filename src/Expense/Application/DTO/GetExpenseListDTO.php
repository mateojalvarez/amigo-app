<?php

namespace Src\Expense\Application\DTO;

readonly class GetExpenseListDTO
{
    public function __construct(
        private string $userUuid,
        private ?string $groupUuid,
        private ?string $fromDate,
        private ?int $categoryId
    ) {}

    public function getUserUuid(): string
    {
        return $this->userUuid;
    }

    public function getGroupUuid(): ?string
    {
        return $this->groupUuid;
    }

    public function getFromDate(): ?string
    {
        return $this->fromDate;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }
}
