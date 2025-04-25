<?php

namespace Src\Balance\Application\UseCases;

use Src\Balance\Application\DTO\GetBalanceListDTO;
use Src\Shared\Services\Balance\Contracts\BalanceManagement;
use Src\Shared\Services\Balance\Entities\Lists\BalanceList;
use Src\Shared\Services\Balance\ValueObjects\UserUuid;

readonly class GetBalanceListUseCase
{
    public function __construct(
        private GetBalanceListDTO $dto,
        private BalanceManagement $balanceManagement
    ) {}

    public function __invoke(): BalanceList
    {
        return $this->balanceManagement->getBalanceList(
            new UserUuid($this->dto->getUserUuid())
        );
    }
}
