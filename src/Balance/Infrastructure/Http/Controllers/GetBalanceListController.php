<?php

namespace Src\Balance\Infrastructure\Http\Controllers;

use Auth;
use Illuminate\Http\JsonResponse;
use Src\Balance\Application\DTO\GetBalanceListDTO;
use Src\Balance\Application\UseCases\GetBalanceListUseCase;
use Src\Balance\Infrastructure\Http\Resources\BalanceListResource;
use Src\Shared\Services\Balance\Contracts\BalanceManagement;

readonly class GetBalanceListController
{
    public function __construct(
        private BalanceManagement $balanceManagement
    ) {}

    public function __invoke(): JsonResponse
    {
        $useCase = new GetBalanceListUseCase(
            new GetBalanceListDTO(
                Auth::user()->uuid,
            ),
            $this->balanceManagement
        );

        $responseResource = new BalanceListResource($useCase());

        return response()->json($responseResource->toArray());
    }
}
