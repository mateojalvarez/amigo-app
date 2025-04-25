<?php

namespace Src\Shared\Services\Balance\Entities;

use Src\Shared\Services\Balance\ValueObjects\BalanceUuid;
use Src\Shared\Services\Balance\ValueObjects\UserUuid;
use Src\Shared\ValueObjects\Amount;

class BalanceEntity
{
    private BalanceUuid $uuid;

    public function __construct(
        private readonly UserUuid $fromUser,
        private readonly UserUuid $toUser,
        private Amount $amount
    ) {}

    public function getFromUser(): UserUuid
    {
        return $this->fromUser;
    }

    public function getToUser(): UserUuid
    {
        return $this->toUser;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function generateUuid(): self
    {
        $this->uuid = new BalanceUuid(uniqid());

        return $this;
    }

    public function getUuid(): BalanceUuid
    {
        return $this->uuid;
    }

    public function setUuid(BalanceUuid $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function updateAmount(Amount $amount): void
    {
        $this->amount = new Amount(
            $this->amount->getValue() + $amount->getValue(),
            $this->amount->getCurrency()
        );
    }
}
