<?php

namespace Src\Shared\Services\Balance;

use Src\Shared\Services\Balance\Contracts\BalanceManagement;
use Src\Shared\Services\Balance\Entities\BalanceEntity;
use Src\Shared\Services\Balance\Entities\Lists\BalanceList;
use Src\Shared\Services\Balance\Repositories\Contracts\BalanceRepository;
use Src\Shared\Services\Balance\ValueObjects\UserUuid;
use Src\Shared\ValueObjects\Amount;

readonly class BalanceService implements BalanceManagement
{
    public function __construct(
        private BalanceRepository $repository
    ) {}

    public function save(UserUuid $fromUser, UserUuid $toUser, Amount $amount): void
    {
        $balance = $this->repository->findFromUsers($fromUser, $toUser, $amount->getCurrency());

        if (! $balance) {
            $balance = new BalanceEntity($fromUser, $toUser, $amount);
            $balance->generateUuid();
        } else {
            $balance->updateAmount($amount);
        }

        $this->repository->save(
            $balance
        );

        $amount->negateValue();

        $balance = $this->repository->findFromUsers($toUser, $fromUser, $amount->getCurrency());

        if (! $balance) {
            $balance = new BalanceEntity($toUser, $fromUser, $amount);
            $balance->generateUuid();
        } else {
            $balance->updateAmount($amount);
        }

        $this->repository->save(
            $balance
        );
    }

    public function getBalanceList(UserUuid $userUuid): BalanceList
    {
        return $this->repository->findByFromUser($userUuid);
    }
}
