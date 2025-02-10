<?php

namespace Src\Auth\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Auth\Application\UseCases\RefreshAuthUseCase;
use Src\Auth\Domain\Repositories\UserRepository;
use Src\Auth\Infrastructure\Http\Requests\RefreshAuthRequest;
use Src\Auth\Infrastructure\Http\Resources\AuthResource;

readonly class RefreshAuthController
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function __invoke(RefreshAuthRequest $request): JsonResponse
    {
        $useCase = new RefreshAuthUseCase(
            $request->dto(),
            $this->userRepository
        );

        $auth = $useCase();

        return response()->json([
            AuthResource::toArray($auth),
        ]);
    }
}
