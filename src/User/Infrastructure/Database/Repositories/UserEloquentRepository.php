<?php

namespace Src\User\Infrastructure\Database\Repositories;

use App\Models\User;
use Log;
use Src\Shared\Exceptions\DatabaseException;
use Src\User\Domain\Entities\UserEntity;
use Src\User\Domain\Repositories\UserRepository;
use Src\User\Domain\ValueObjects\UserId;
use Throwable;

class UserEloquentRepository implements UserRepository
{
    /**
     * @throws DatabaseException
     */
    public function save(UserEntity $userEntity): void
    {
        try {

            $user           = new User();
            $user->name     = $userEntity->getName();
            $user->email    = $userEntity->getEmail()->value();
            $user->uuid     = $userEntity->getUuid()->value();
            $user->password = $userEntity->getPassword()?->hashedValue();
            $user->save();

            $userEntity->setId(new UserId($user->id));

        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());

            throw new DatabaseException();
        }
    }
}
