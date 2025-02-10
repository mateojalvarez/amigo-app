<?php

namespace Src\Expense\Application\UseCases;

use Src\Expense\Application\DTO\CreateRecurringExpenseDTO;
use Src\Expense\Domain\Exceptions\InvalidDescriptionLengthException;
use Src\Expense\Domain\Factories\ExpenseFactory;
use Src\Expense\Domain\Factories\RecurringExpenseFactory;
use Src\Expense\Domain\Repositories\ExpenseRepository;
use Src\Expense\Domain\Repositories\RecurringExpenseRepository;
use Src\Expense\Domain\ValueObjects\RecurringExpenseInterval;

readonly class CreateRecurringExpenseUseCase
{
    public function __construct(
        private CreateRecurringExpenseDTO $dto,
        private RecurringExpenseRepository $repository,
        private ExpenseRepository $expenseRepository
    ) {}

    /**
     * @throws InvalidDescriptionLengthException
     */
    public function __invoke(): void
    {
        $recurringExpense = RecurringExpenseFactory::fromDTO($this->dto);

        $this->repository->save(
            $recurringExpense
        );

        $expense = ExpenseFactory::fromRecurringExpense($recurringExpense);

        $this->expenseRepository->save($expense);

        $this->repository->saveInterval(
            new RecurringExpenseInterval(
                $recurringExpense->getId(),
                $expense->getId(),
                $recurringExpense->getTotalIntervals()
            )
        );
    }
}
