<?php

namespace Src\Balance\Infrastructure\Http\Resources;

use Src\Shared\Services\Balance\Entities\Lists\BalanceList;

class BalanceListResource
{
    public function __construct(
        private readonly BalanceList $balanceList
    ) {}

    public function toArray(): array
    {
        $response = [];

        foreach ($this->balanceList->all() as $balance) {
            if (array_key_exists('')) {
                $response[] = [
                    'from_user_uuid' => $balance->getFromUser()->value(),
                    'to_user'        => $balance->getToUser()->value(),
                    'amount'         => $balance->getAmount()->getValue(),
                    'currency'       => $balance->getAmount()->getCurrency(),
                ];
            }
        }
    }
}
