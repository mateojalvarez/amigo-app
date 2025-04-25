<?php

namespace Src\Auth\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Google2FA;
use Src\Auth\Application\UseCases\VerifyTwoFactorCodeUseCase;
use Src\Auth\Domain\Exceptions\FailToVerifyTwoFactorCode;
use Src\Auth\Domain\Repositories\PersonalAccessTokenRepository;
use Src\Auth\Domain\Repositories\TwoFactorAuthRepository;
use Src\Auth\Infrastructure\Http\Requests\VerifyTwoFactorCodeRequest;
use Src\Shared\Enums\StatusCodeEnum;

readonly class VerifyTwoFactorCodeController
{
    public function __construct(
        private TwoFactorAuthRepository $repository,
        private PersonalAccessTokenRepository $accessTokenRepository,
        private Google2FA $google2FA
    ) {}

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws InvalidCharactersException
     * @throws SecretKeyTooShortException
     * @throws FailToVerifyTwoFactorCode
     */
    public function __invoke(VerifyTwoFactorCodeRequest $request): JsonResponse
    {
        $useCase = new VerifyTwoFactorCodeUseCase(
            $request->dto(),
            $this->repository,
            $this->accessTokenRepository,
            $this->google2FA
        );

        $useCase();

        return response()->json([
            'message' => 'Two factor code verified successfully',
        ], StatusCodeEnum::OK->value);
    }
}
