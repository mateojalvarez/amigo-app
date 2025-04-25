<?php

namespace Src\Shared\Services\Balance\Entities\Lists;

use Src\Shared\Enums\CurrencyEnum;
use Src\Shared\Services\Balance\Entities\BalanceEntity;

class BalanceList
{
    /**
     * @var array<BalanceEntity>
     */
    private array $items;

    /**
     * @param array<BalanceEntity> $items
     */
    public function __construct(
        array $items = []
    ) {
        $this->items = $items;
    }

    public function add(BalanceEntity $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @return BalanceEntity[]
     */
    public function all(): array
    {
        return $this->items;
    }

    public function getByCurrency(CurrencyEnum $currency): ?BalanceEntity
    {
        foreach ($this->items as $item) {
            if ($item->getAmount()->getCurrency()->equals($currency)) {
                return $item;
            }
        }

        return null;
    }
}
