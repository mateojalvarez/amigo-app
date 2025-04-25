<?php

namespace Src\Auth\Infrastructure\Database\Repositories;

use Log;
use Src\Auth\Domain\Repositories\TwoFactorAuthRepository;
use Src\Auth\Domain\ValueObjects\TwoFactorAuthKey;
use Src\Auth\Domain\ValueObjects\User;
use Src\Shared\Exceptions\DatabaseException;
use Throwable;

class TwoFactorAuthEloquentRepository implements TwoFactorAuthRepository
{
    /**
     * @throws DatabaseException
     */
    public function save(TwoFactorAuthKey $key): void
    {
        try {

            \App\Models\TwoFactorAuthKey::create([
                'user_id' => $key->getUserId(),
                'secret'  => $key->getSecret(),
            ]);

        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());

            throw new DatabaseException();
        }
    }

    public function getKey(User $user): TwoFactorAuthKey
    {
        try {

            $key = \App\Models\TwoFactorAuthKey::where('user_id', $user->getId())->firstOrFail();

            return new TwoFactorAuthKey($user, $key->secret);

        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());

            throw new DatabaseException();
        }
    }
}
