<?php

namespace Tests\Integration\Auth\Infrastructure\Database\Repositories;

use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Src\Auth\Domain\Exceptions\InvalidCredentialsException;
use Src\Auth\Domain\Exceptions\InvalidRefreshTokenException;
use Src\Auth\Domain\Repositories\UserRepository;
use Src\Auth\Domain\ValueObjects\Credentials;
use Src\Auth\Domain\ValueObjects\RefreshToken;
use Tests\TestCase;
use Throwable;

/**
 * @internal
 */
class UserEloquentRepositoryTest extends TestCase
{
    private User $user;
    private UserRepository $repository;

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user       = User::factory()->create();
        $this->repository = $this->app->make(UserRepository::class);
    }

    public function test_should_login_success(): void
    {
        $auth = $this->repository->login(
            new Credentials(
                $this->user->email,
                'password'
            )
        );

        self::assertNotNull($auth->getAccessToken());

        self::assertNotNull($auth->getRefreshToken());

        self::assertEquals($this->user->id, $auth->getUser()->getId());
    }

    public function test_should_fail_by_invalid_credentials(): void
    {
        try {
            $this->repository->login(
                new Credentials(
                    $this->user->email,
                    'invalid-password'
                )
            );
        } catch (Throwable $th) {
            $this->assertTrue(
                $th instanceof InvalidCredentialsException
            );
        }

        try {
            $this->repository->login(
                new Credentials(
                    'test@test.com',
                    'password'
                )
            );
        } catch (Throwable $th) {
            $this->assertTrue(
                $th instanceof InvalidCredentialsException
            );
        }
    }

    public function test_should_refresh_auth_successfully(): void
    {
        $auth = $this->repository->login(
            new Credentials(
                $this->user->email,
                'password'
            )
        );

        $refreshedAuth = $this->repository->refreshToken(
            $auth->getRefreshToken()
        );

        self::assertNotNull($refreshedAuth->getAccessToken());

        self::assertNotNull($auth->getRefreshToken());

        self::assertEquals($this->user->id, $auth->getUser()->getId());
    }

    public function test_should_fail_by_invalid_refresh_token(): void
    {
        $this->expectException(InvalidRefreshTokenException::class);

        $this->repository->refreshToken(
            new RefreshToken('invalid-refresh-token')
        );
    }

}
