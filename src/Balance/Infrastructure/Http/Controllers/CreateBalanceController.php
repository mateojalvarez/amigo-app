<?php

namespace Src\Balance\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Balance\Application\UseCases\CreateBalanceUseCase;
use Src\Balance\Infrastructure\Http\Requests\CreateBalanceRequest;
use Src\Shared\Enums\StatusCodeEnum;
use Src\Shared\Services\Balance\Exceptions\AlreadyExistingBalanceException;
use Src\Shared\Services\Balance\Repositories\Contracts\BalanceRepository;

readonly class CreateBalanceController
{
    public function __construct(
        private BalanceRepository $repository
    ) {}

    /**
     * @throws AlreadyExistingBalanceException
     */
    public function __invoke(CreateBalanceRequest $request): JsonResponse
    {
        $useCase = new CreateBalanceUseCase(
            $request->dto(),
            $this->repository
        );

        $useCase();

        return response()->json(status: StatusCodeEnum::CREATED->value);
    }
}
