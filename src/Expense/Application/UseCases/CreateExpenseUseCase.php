<?php

namespace Src\Expense\Application\UseCases;

use Src\Expense\Application\DTO\CreateExpenseDTO;
use Src\Expense\Domain\Exceptions\InvalidDescriptionLengthException;
use Src\Expense\Domain\Exceptions\InvalidNoteLengthException;
use Src\Expense\Domain\Factories\ExpenseFactory;
use Src\Expense\Domain\Repositories\ExpenseRepository;

readonly class CreateExpenseUseCase
{
    public function __construct(
        private CreateExpenseDTO $dto,
        private ExpenseRepository $repository
    ) {}

    /**
     * @throws InvalidNoteLengthException
     * @throws InvalidDescriptionLengthException
     */
    public function __invoke(): void
    {
        $this->repository->save(
            ExpenseFactory::fromDTO($this->dto)
        );
    }
}
