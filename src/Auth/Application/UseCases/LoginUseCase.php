<?php

namespace Src\Auth\Application\UseCases;

use Src\Auth\Application\DTO\LoginDTO;
use Src\Auth\Domain\Repositories\UserRepository;
use Src\Auth\Domain\ValueObjects\Credentials;
use Src\Auth\Domain\ValueObjects\Auth;

readonly class LoginUseCase
{
    public function __construct(
        private LoginDTO $dto,
        private UserRepository $repository
    ) {}

    public function __invoke(): Auth
    {
        return $this->repository->login(
            new Credentials(
                $this->dto->getEmail(),
                $this->dto->getPassword()
            )
        );
    }
}
