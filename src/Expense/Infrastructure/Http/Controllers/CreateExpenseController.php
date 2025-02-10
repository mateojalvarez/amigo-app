<?php

namespace Src\Expense\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Expense\Application\UseCases\CreateExpenseUseCase;
use Src\Expense\Domain\Exceptions\InvalidDescriptionLengthException;
use Src\Expense\Domain\Exceptions\InvalidNoteLengthException;
use Src\Expense\Domain\Repositories\ExpenseRepository;
use Src\Expense\Infrastructure\Http\Requests\CreateExpenseRequest;
use Src\Shared\Enums\StatusCodeEnum;

readonly class CreateExpenseController
{
    public function __construct(
        private ExpenseRepository $repository
    ) {}

    /**
     * @throws InvalidNoteLengthException
     * @throws InvalidDescriptionLengthException
     */
    public function __invoke(CreateExpenseRequest $request): JsonResponse
    {
        $useCase = new CreateExpenseUseCase(
            $request->dto(),
            $this->repository
        );

        $useCase();

        return response()->json([], StatusCodeEnum::CREATED->value);
    }
}
