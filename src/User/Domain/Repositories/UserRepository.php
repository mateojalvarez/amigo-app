<?php

namespace Src\User\Domain\Repositories;

use Src\User\Domain\Entities\UserEntity;

interface UserRepository
{
    public function save(UserEntity $userEntity): void;

    public function findById(int $userId): ?UserEntity;
}
