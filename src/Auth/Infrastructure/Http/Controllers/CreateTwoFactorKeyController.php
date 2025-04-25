<?php

namespace Src\Auth\Infrastructure\Http\Controllers;

use Auth;
use Illuminate\Http\JsonResponse;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Google2FA;
use Src\Auth\Application\DTO\CreateTwoFactorKeyDTO;
use Src\Auth\Application\UseCases\CreateTwoFactorKeyUseCase;
use Src\Auth\Domain\Repositories\TwoFactorAuthRepository;
use Src\Auth\Infrastructure\Http\Resources\TwoFactorKeyResource;
use Src\Shared\Enums\StatusCodeEnum;

readonly class CreateTwoFactorKeyController
{
    public function __construct(
        private TwoFactorAuthRepository $repository,
        private Google2FA $google2FA
    ) {}

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws SecretKeyTooShortException
     * @throws InvalidCharactersException
     */
    public function __invoke(): JsonResponse
    {
        $useCase = new CreateTwoFactorKeyUseCase(
            new CreateTwoFactorKeyDTO(Auth::id(), Auth::user()->email, config('app.name')),
            $this->repository,
            $this->google2FA
        );

        $twoFactorKeyResource = new TwoFactorKeyResource(
            $useCase()
        );

        return response()->json($twoFactorKeyResource->toArray(), StatusCodeEnum::CREATED->value);
    }
}
