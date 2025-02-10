<?php

namespace Src\Expense\Application\UseCases;

use Carbon\Carbon;
use Src\Expense\Application\DTO\GetExpenseListDTO;
use Src\Expense\Domain\Entities\Lists\ExpenseList;
use Src\Expense\Domain\Enums\ExpenseCategoryEnum;
use Src\Expense\Domain\Repositories\ExpenseRepository;
use Src\Expense\Domain\Repositories\RecurringExpenseRepository;
use Src\Expense\Domain\ValueObjects\ExpenseListIdentifier;
use Src\Expense\Domain\ValueObjects\GroupUuid;
use Src\Expense\Domain\ValueObjects\UserUuid;

readonly class GetExpenseListUseCase
{
    public function __construct(
        private GetExpenseListDTO $dto,
        private ExpenseRepository $expenseRepository,
        private RecurringExpenseRepository $recurringExpenseRepository
    ) {}

    public function __invoke(): ExpenseList
    {
        $identifier = new ExpenseListIdentifier(
            new UserUuid($this->dto->getUserUuid()),
            $this->dto->getGroupUuid() ? new GroupUuid($this->dto->getGroupUuid()) : null,
            $this->dto->getFromDate() ? Carbon::parse($this->dto->getFromDate()) : null,
            $this->dto->getCategoryId() ? ExpenseCategoryEnum::from($this->dto->getCategoryId()) : null
        );

        $expenseList = $this->expenseRepository->getExpenseList($identifier);

        $recurringExpenseList = $this->recurringExpenseRepository->getList($identifier);

        $expenseList->merge($recurringExpenseList->getExpenses());

        return $expenseList;
    }
}
