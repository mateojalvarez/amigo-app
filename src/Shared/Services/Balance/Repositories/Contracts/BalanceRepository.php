<?php

namespace Src\Shared\Services\Balance\Repositories\Contracts;

use Src\Shared\Enums\CurrencyEnum;
use Src\Shared\Services\Balance\Entities\BalanceEntity;
use Src\Shared\Services\Balance\Entities\Lists\BalanceList;
use Src\Shared\Services\Balance\ValueObjects\BalanceUuid;
use Src\Shared\Services\Balance\ValueObjects\UserUuid;

interface BalanceRepository
{
    public function save(BalanceEntity $balance): void;

    public function find(BalanceEntity $balance): ?BalanceEntity;

    public function findByFromUser(UserUuid $fromUser): BalanceList;

    public function findByToUser(UserUuid $toUser): BalanceList;

    public function findByUuid(BalanceUuid $balanceUuid): ?BalanceEntity;

    public function findFromUsers(UserUuid $fromUser, UserUuid $toUser, CurrencyEnum $currency): ?BalanceEntity;
}
