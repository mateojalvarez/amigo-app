<?php

namespace Src\Shared\Services\Balance\Contracts;

use Src\Shared\Services\Balance\Entities\Lists\BalanceList;
use Src\Shared\Services\Balance\ValueObjects\UserUuid;
use Src\Shared\ValueObjects\Amount;

interface BalanceManagement
{
    public function save(UserUuid $fromUser, UserUuid $toUser, Amount $amount): void;

    public function getBalanceList(UserUuid $userUuid): BalanceList;
}
