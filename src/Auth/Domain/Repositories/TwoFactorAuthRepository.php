<?php

namespace Src\Auth\Domain\Repositories;

use Src\Auth\Domain\ValueObjects\TwoFactorAuthKey;
use Src\Auth\Domain\ValueObjects\User;

interface TwoFactorAuthRepository
{
    public function save(TwoFactorAuthKey $key): void;

    public function getKey(User $user): TwoFactorAuthKey;
}
