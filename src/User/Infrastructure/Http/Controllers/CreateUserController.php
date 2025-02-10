<?php

namespace Src\User\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Shared\Enums\StatusCodeEnum;
use Src\Shared\Exceptions\Password\NotHasNumbersException;
use Src\Shared\Exceptions\Password\NotHasSpecialCharactersException;
use Src\Shared\Exceptions\Password\NotHasUpperAndLowerCaseException;
use Src\Shared\Exceptions\Password\NotMeetMinimumOrMaximumLengthException;
use Src\User\Application\UseCases\CreateUserUseCase;
use Src\User\Domain\Repositories\UserRepository;
use Src\User\Infrastructure\Http\Requests\CreateUserRequest;
use Src\User\Infrastructure\Http\Resources\UserResource;

readonly class CreateUserController
{
    public function __construct(
        private UserRepository $repository
    ) {}

    /**
     * @throws NotHasNumbersException
     * @throws NotHasSpecialCharactersException
     * @throws NotMeetMinimumOrMaximumLengthException
     * @throws NotHasUpperAndLowerCaseException
     */
    public function __invoke(CreateUserRequest $request): JsonResponse
    {
        $useCase = new CreateUserUseCase(
            $request->dto(),
            $this->repository
        );

        $user = $useCase();

        return response()->json(
            UserResource::toArray($user),
            StatusCodeEnum::CREATED->value
        );
    }
}
