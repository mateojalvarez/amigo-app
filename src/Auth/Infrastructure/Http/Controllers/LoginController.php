<?php

namespace Src\Auth\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Auth\Application\UseCases\LoginUseCase;
use Src\Auth\Domain\Repositories\UserRepository;
use Src\Auth\Infrastructure\Http\Requests\LoginRequest;
use Src\Auth\Infrastructure\Http\Resources\AuthResource;

readonly class LoginController
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function __invoke(LoginRequest $request): JsonResponse
    {
        $useCase = new LoginUseCase(
            $request->dto(),
            $this->userRepository
        );

        $token = $useCase();

        return response()->json(
            AuthResource::toArray($token)
        );
    }
}
