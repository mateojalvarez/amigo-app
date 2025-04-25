<?php

namespace Src\Auth\Application\UseCases;

use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Google2FA;
use Src\Auth\Application\DTO\CreateTwoFactorKeyDTO;
use Src\Auth\Domain\Repositories\TwoFactorAuthRepository;
use Src\Auth\Domain\ValueObjects\TwoFactorAuthKey;
use Src\Auth\Domain\ValueObjects\TwoFactorAuthQR;
use Src\Auth\Domain\ValueObjects\User;

readonly class CreateTwoFactorKeyUseCase
{
    public function __construct(
        private CreateTwoFactorKeyDTO $dto,
        private TwoFactorAuthRepository $repository,
        private Google2FA $google2FA
    ) {}

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws SecretKeyTooShortException
     * @throws InvalidCharactersException
     */
    public function __invoke(): TwoFactorAuthKey
    {
        $secret = $this->google2FA->generateSecretKey();

        $twoFactorKey = new TwoFactorAuthKey(
            new User($this->dto->getUserId()),
            $secret,
        );

        $this->repository->save($twoFactorKey);

        $qrCode = $this->google2FA->getQRCodeUrl(
            $this->dto->getAppName(),
            $this->dto->getUserEmail(),
            $secret
        );

        $twoFactorKey->setTwoFactorAuthQR(
            new TwoFactorAuthQR(
                $qrCode
            )
        );

        return $twoFactorKey;
    }
}
