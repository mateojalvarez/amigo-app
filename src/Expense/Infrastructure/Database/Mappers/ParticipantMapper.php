<?php

namespace Src\Expense\Infrastructure\Database\Mappers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Src\Expense\Domain\ValueObjects\UserUuid;

class ParticipantMapper
{
    public static function fromModelToVO(Model|User $user): UserUuid
    {
        return new UserUuid(
            $user->uuid
        );
    }
}
