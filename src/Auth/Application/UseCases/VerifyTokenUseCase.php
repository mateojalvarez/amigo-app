<?php

namespace Src\Auth\Application\UseCases;

use Src\Auth\Application\DTO\VerifyTokenDTO;
use Src\Auth\Domain\Exceptions\UntrustedRequestException;
use Src\Auth\Domain\Repositories\PersonalAccessTokenRepository;
use Src\Auth\Domain\ValueObjects\Token;

readonly class VerifyTokenUseCase
{
    public function __construct(
        private VerifyTokenDTO $dto,
        private PersonalAccessTokenRepository $repository
    ) {}

    /**
     * @throws UntrustedRequestException
     */
    public function __invoke(): void
    {
        $tokenVerified = $this->repository->isVerified(
            new Token($this->dto->getAuthToken())
        );

        if (! $tokenVerified) {
            throw new UntrustedRequestException();
        }
    }
}
