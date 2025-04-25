<?php

namespace Src\Auth\Infrastructure\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Src\Auth\Application\DTO\VerifyTokenDTO;
use Src\Auth\Application\UseCases\VerifyTokenUseCase;
use Src\Auth\Domain\Exceptions\UntrustedRequestException;
use Src\Auth\Domain\Repositories\PersonalAccessTokenRepository;
use Symfony\Component\HttpFoundation\Response;

readonly class EnsureTokenIsVerified
{
    public function __construct(
        private PersonalAccessTokenRepository $repository,
    ) {}

    /**
     * @throws UntrustedRequestException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        $useCase = new VerifyTokenUseCase(
            new VerifyTokenDTO($token),
            $this->repository
        );

        $useCase();

        return $next($request);
    }
}
