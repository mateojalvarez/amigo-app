<?php

namespace Src\User\Application\UseCases;

use Src\Shared\Exceptions\Password\NotHasNumbersException;
use Src\Shared\Exceptions\Password\NotHasSpecialCharactersException;
use Src\Shared\Exceptions\Password\NotHasUpperAndLowerCaseException;
use Src\Shared\Exceptions\Password\NotMeetMinimumOrMaximumLengthException;
use Src\Shared\ValueObjects\Email;
use Src\User\Application\DTO\CreateUserDTO;
use Src\User\Domain\Entities\UserEntity;
use Src\User\Domain\Repositories\UserRepository;

readonly class CreateUserUseCase
{
    public function __construct(
        private CreateUserDTO $dto,
        private UserRepository $repository
    ) {}

    /**
     * @throws NotHasNumbersException
     * @throws NotHasSpecialCharactersException
     * @throws NotMeetMinimumOrMaximumLengthException
     * @throws NotHasUpperAndLowerCaseException
     */
    public function __invoke(): UserEntity
    {
        $user = new UserEntity(
            $this->dto->getName(),
            new Email($this->dto->getEmail()),
            $this->dto->getUuid(),
            $this->dto->getPassword()
        );

        $this->repository->save($user);

        return $user;
    }
}
