<?php

namespace Tests\Integration\Auth\Infrastructure\Database\Repositories;

use App\Models\User;
use Src\Auth\Domain\Repositories\TwoFactorAuthRepository;
use Src\Auth\Domain\ValueObjects\TwoFactorAuthKey;
use Tests\TestCase;

/**
 * @internal
 */
class TwoFactorAuthEloquentAuthRepositorTest extends TestCase
{
    private User $user;

    private TwoFactorAuthRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->repository = app(TwoFactorAuthRepository::class);
    }

    public function test_should_save_and_get_key_successfully(): void
    {
        $uuid = fake()->uuid();

        $this->repository->save(new TwoFactorAuthKey(
            new \Src\Auth\Domain\ValueObjects\User($this->user->id),
            $uuid
        ));

        $this->assertDatabaseHas('two_factor_auth_keys', [
            'user_id' => $this->user->id,
            'secret'  => $uuid,
        ]);
    }

    public function test_should_get_key_successfully(): void
    {
        $uuid = fake()->uuid();

        $this->repository->save(new TwoFactorAuthKey(
            new \Src\Auth\Domain\ValueObjects\User($this->user->id),
            $uuid
        ));

        $key = $this->repository->getKey(
            new \Src\Auth\Domain\ValueObjects\User($this->user->id)
        );

        self::assertEquals($key->getSecret(), $uuid);
    }
}
