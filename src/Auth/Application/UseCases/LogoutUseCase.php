<?php

namespace Src\Auth\Application\UseCases;

use Src\Auth\Application\DTO\LogoutDTO;
use Src\Auth\Domain\Repositories\UserRepository;
use Src\Auth\Domain\ValueObjects\User;

readonly class LogoutUseCase
{
    public function __construct(
        private LogoutDTO $dto,
        private UserRepository $repository
    ) {}

    public function __invoke(): void
    {
        $this->repository->logout(
            new User(
                $this->dto->getUserId()
            )
        );
    }
}
