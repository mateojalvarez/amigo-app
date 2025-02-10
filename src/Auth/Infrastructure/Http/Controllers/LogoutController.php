<?php

namespace Src\Auth\Infrastructure\Http\Controllers;

use Auth;
use Illuminate\Http\JsonResponse;
use Src\Auth\Application\DTO\LogoutDTO;
use Src\Auth\Application\UseCases\LogoutUseCase;
use Src\Auth\Domain\Repositories\UserRepository;
use Src\Shared\Enums\StatusCodeEnum;

readonly class LogoutController
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function __invoke(): JsonResponse
    {
        $useCase = new LogoutUseCase(
            new LogoutDTO(
                Auth::id()
            ),
            $this->userRepository
        );

        $useCase();

        return response()->json([], StatusCodeEnum::NO_CONTENT->value);
    }
}
