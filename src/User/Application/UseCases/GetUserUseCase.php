<?php

namespace Src\User\Application\UseCases;

use Src\User\Application\DTO\GetUserDTO;
use Src\User\Domain\Entities\UserEntity;
use Src\User\Domain\Exceptions\UserNotFoundException;
use Src\User\Domain\Repositories\UserRepository;

readonly class GetUserUseCase
{
    public function __construct(
        private GetUserDTO $dto,
        private UserRepository $repository
    ) {}

    /**
     * @throws UserNotFoundException
     */
    public function __invoke(): UserEntity
    {
        $user = $this->repository->findById($this->dto->getUserId());

        if (! $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
