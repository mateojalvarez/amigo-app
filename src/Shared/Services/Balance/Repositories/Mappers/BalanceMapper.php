<?php

namespace Src\Shared\Services\Balance\Repositories\Mappers;

use App\Models\Balance;
use Ramsey\Collection\Collection;
use Src\Shared\Enums\CurrencyEnum;
use Src\Shared\Services\Balance\Entities\BalanceEntity;
use Src\Shared\Services\Balance\Entities\Lists\BalanceList;
use Src\Shared\Services\Balance\ValueObjects\UserUuid;
use Src\Shared\ValueObjects\Amount;

class BalanceMapper
{
    /**
     * @param Collection<int, Balance> $collection
     */
    public static function fromCollectionToList(Collection $collection): BalanceList
    {
        $balanceList = new BalanceList();

        foreach ($collection as $balanceModel) {
            $balanceList->add(
                self::fromModelToEntity($balanceModel)
            );
        }

        return $balanceList;
    }

    public static function fromModelToEntity(Balance $balanceModel): BalanceEntity
    {
        $balance = new BalanceEntity(
            UserUuid::fromString($balanceModel->fromUser->uuid),
            UserUuid::fromString($balanceModel->toUser->uuid),
            new Amount(
                $balanceModel->amount,
                CurrencyEnum::from($balanceModel->currency_id)
            )
        );
        $balance->setUuid(
            $balanceModel->uuid
        );

        return $balance;
    }
}
