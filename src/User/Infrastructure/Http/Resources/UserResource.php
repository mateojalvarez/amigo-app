<?php

namespace Src\User\Infrastructure\Http\Resources;

use Src\User\Domain\Entities\UserEntity;

class UserResource
{
    public static function toArray(UserEntity $user): array
    {
        return [
            'name'  => $user->getName(),
            'email' => $user->getEmail()->value(),
            'uuid'  => $user->getUuid()->value(),
        ];
    }
}
