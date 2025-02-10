<?php

namespace Src\Expense\Domain\ValueObjects;

use Carbon\Carbon;
use Src\Expense\Domain\Enums\ExpenseCategoryEnum;

readonly class ExpenseListIdentifier
{
    public function __construct(
        private UserUuid $userUuid,
        private ?GroupUuid $groupUuid = null,
        private ?Carbon $fromDate = null,
        private ?ExpenseCategoryEnum $category = null
    ) {}

    public function getUserUuid(): UserUuid
    {
        return $this->userUuid;
    }

    public function getGroupUuid(): ?GroupUuid
    {
        return $this->groupUuid;
    }

    public function getFromDate(): ?Carbon
    {
        return $this->fromDate;
    }

    public function getCategory(): ?ExpenseCategoryEnum
    {
        return $this->category;
    }
}
