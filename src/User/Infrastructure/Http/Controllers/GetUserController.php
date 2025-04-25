<?php

namespace Src\User\Infrastructure\Http\Controllers;

use Auth;
use Illuminate\Http\JsonResponse;
use Src\User\Application\DTO\GetUserDTO;
use Src\User\Application\UseCases\GetUserUseCase;
use Src\User\Domain\Exceptions\UserNotFoundException;
use Src\User\Domain\Repositories\UserRepository;
use Src\User\Infrastructure\Http\Resources\UserResource;

class GetUserController
{
    public function __construct(
        private UserRepository $repository
    ) {}

    /**
     * @throws UserNotFoundException
     */
    public function __invoke(): JsonResponse
    {
        $useCase = new GetUserUseCase(
            new GetUserDTO(
                (int) Auth::id()
            ),
            $this->repository
        );

        return response()->json(
            UserResource::toArray($useCase())
        );
    }
}
