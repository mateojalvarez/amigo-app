<?php

namespace Tests\Integration\Auth\Infrastructure\Database\Repositories;

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
use Src\Auth\Domain\Repositories\PersonalAccessTokenRepository;
use Src\Auth\Domain\ValueObjects\Token;
use Tests\TestCase;

/**
 * @internal
 */
class PersonalAccessTokenEloquentRepositoryTest extends TestCase
{
    private User $user;

    private PersonalAccessTokenRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->repository = app(PersonalAccessTokenRepository::class);
    }

    public function test_should_validate_token_successfully(): void
    {
        $token = $this->user->createToken('auth_token');

        $tokenObject = new Token($token->plainTextToken);

        $tokenRetrieved = $this->repository->isVerified(
            $tokenObject
        );

        self::assertFalse($tokenRetrieved);

        $this->repository->setAsVerified($tokenObject);

        $tokenRetrieved = $this->repository->isVerified(
            $tokenObject
        );

        self::assertTrue($tokenRetrieved);
    }
}
