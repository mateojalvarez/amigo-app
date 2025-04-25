<?php

namespace Tests\Integration\Auth\Infrastructure\Http\Middlewares;

use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Src\Auth\Application\DTO\VerifyTokenDTO;
use Src\Auth\Application\UseCases\VerifyTokenUseCase;
use Src\Auth\Domain\Exceptions\UntrustedRequestException;
use Src\Auth\Domain\Repositories\PersonalAccessTokenRepository;
use Tests\TestCase;

class EnsureTokenIsVerifiedTest extends TestCase
{
    private PersonalAccessTokenRepository $repository;

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->app->make(PersonalAccessTokenRepository::class);
    }

    public function test_should_get_untrusted_request_exception(): void
    {
        $this->expectException(UntrustedRequestException::class);

        $token = User::factory()->create()->createToken('auth_token')->plainTextToken;

        $useCase = new VerifyTokenUseCase(
            new VerifyTokenDTO($token),
            $this->repository
        );

        $useCase();
    }
}
