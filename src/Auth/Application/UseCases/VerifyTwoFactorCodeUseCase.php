<?php

namespace Src\Auth\Application\UseCases;

use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Google2FA;
use Src\Auth\Application\DTO\VerifyTwoFactorCodeDTO;
use Src\Auth\Domain\Exceptions\FailToVerifyTwoFactorCode;
use Src\Auth\Domain\Repositories\PersonalAccessTokenRepository;
use Src\Auth\Domain\Repositories\TwoFactorAuthRepository;
use Src\Auth\Domain\ValueObjects\Token;
use Src\Auth\Domain\ValueObjects\User;

readonly class VerifyTwoFactorCodeUseCase
{
    public function __construct(
        private VerifyTwoFactorCodeDTO $dto,
        private TwoFactorAuthRepository $repository,
        private PersonalAccessTokenRepository $accessTokenRepository,
        private Google2FA $google2FA
    ) {}

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws SecretKeyTooShortException
     * @throws InvalidCharactersException
     * @throws FailToVerifyTwoFactorCode
     */
    public function __invoke(): void
    {
        $twoFactorKey = $this->repository->getKey(
            new User($this->dto->getUserId())
        );

        if (! $this->google2FA->verifyKey(
            $twoFactorKey->getSecret(),
            $this->dto->getTwoFactorCode()
        )) {
            throw new FailToVerifyTwoFactorCode();
        }

        $this->accessTokenRepository->setAsVerified(
            new Token($this->dto->getAuthToken())
        );
    }
}
