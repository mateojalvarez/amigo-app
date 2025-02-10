<?php

namespace Src\Auth\Application\UseCases;

use Src\Auth\Application\DTO\RefreshAuthDTO;
use Src\Auth\Domain\Repositories\UserRepository;
use Src\Auth\Domain\ValueObjects\Auth;
use Src\Auth\Domain\ValueObjects\RefreshToken;

readonly class RefreshAuthUseCase
{
    public function __construct(
        private RefreshAuthDTO $dto,
        private UserRepository $repository
    ) {}

    public function __invoke(): Auth
    {
        return $this->repository->refreshToken(
            new RefreshToken($this->dto->getRefreshToken())
        );
    }
}
