<?php

namespace Src\Shared\Services\Balance\Repositories;

use App\Models\Balance;
use App\Models\User;
use Log;
use Src\Shared\Enums\CurrencyEnum;
use Src\Shared\Exceptions\DatabaseException;
use Src\Shared\Services\Balance\Entities\BalanceEntity;
use Src\Shared\Services\Balance\Entities\Lists\BalanceList;
use Src\Shared\Services\Balance\Repositories\Contracts\BalanceRepository;
use Src\Shared\Services\Balance\Repositories\Mappers\BalanceMapper;
use Src\Shared\Services\Balance\ValueObjects\BalanceUuid;
use Src\Shared\Services\Balance\ValueObjects\UserUuid;
use Throwable;

class BalanceEloquentRepository implements BalanceRepository
{
    /**
     * @throws DatabaseException
     */
    public function save(BalanceEntity $balance): void
    {
        try {

            $fromUser = User::whereUuid($balance->getFromUser()->value())->select('id')->first();
            $toUser   = User::whereUuid($balance->getToUser()->value())->select('id')->first();

            Balance::updateOrCreate([
                'uuid' => $balance->getUuid()->value(),
            ], [
                'from_user_id' => $fromUser->id,
                'to_user_id'   => $toUser->id,
                'amount'       => $balance->getAmount()->getValue(),
                'currency_id'  => $balance->getAmount()->getCurrency()->value,
            ]);

        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());

            throw new DatabaseException();
        }
    }

    /**
     * @throws DatabaseException
     */
    public function find(BalanceEntity $balance): ?BalanceEntity
    {
        try {

            $fromUser = User::whereUuid($balance->getFromUser()->value())->select('id')->first();
            $toUser   = User::whereUuid($balance->getToUser()->value())->select('id')->first();

            $balanceModel = Balance::where('from_user_id', $fromUser->id)
                ->where('to_user_id', $toUser->id)
                ->where('currency_id', $balance->getAmount()->getCurrency()->value)
                ->with([
                    'fromUser:id,uuid',
                    'toUser:id,uuid',
                ])
                ->first();

            if (! $balanceModel) {
                return null;
            }

            return BalanceMapper::fromModelToEntity($balanceModel);

        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());

            throw new DatabaseException();
        }
    }

    /**
     * @throws DatabaseException
     */
    public function findByFromUser(UserUuid $fromUser): BalanceList
    {
        try {

            $fromUser = User::whereUuid($fromUser->value())->select('id')->first();

            $balances = Balance::where('from_user_id', $fromUser->id)
                ->with([
                    'fromUser:id,uuid',
                    'toUser:id,uuid',
                ])
                ->get();

            return BalanceMapper::fromCollectionToList($balances);

        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());

            throw new DatabaseException();
        }
    }

    /**
     * @throws DatabaseException
     */
    public function findByToUser(UserUuid $toUser): BalanceList
    {
        try {

            $toUser = User::whereUuid($toUser->value())->select('id')->first();

            $balances = Balance::where('to_user_id', $toUser->id)
                ->with([
                    'fromUser:id,uuid',
                    'toUser:id,uuid',
                ])
                ->get();

            return BalanceMapper::fromCollectionToList($balances);

        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());

            throw new DatabaseException();
        }
    }

    /**
     * @throws DatabaseException
     */
    public function findByUuid(BalanceUuid $balanceUuid): ?BalanceEntity
    {
        try {

            $balance = Balance::where('uuid', $balanceUuid->value())
                ->with([
                    'fromUser:id,uuid',
                    'toUser:id,uuid',
                ])
                ->first();

            return BalanceMapper::fromModelToEntity($balance);

        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());

            throw new DatabaseException();
        }
    }

    /**
     * @throws DatabaseException
     */
    public function findFromUsers(UserUuid $fromUser, UserUuid $toUser, CurrencyEnum $currency): ?BalanceEntity
    {
        try {

            $fromUser = User::whereUuid($fromUser->value())->select('id')->first();
            $toUser   = User::whereUuid($toUser->value())->select('id')->first();

            $balance = Balance::where('from_user_id', $fromUser->id)
                ->where('to_user_id', $toUser->id)
                ->with([
                    'fromUser:id,uuid',
                    'toUser:id,uuid',
                ])
                ->first();

            if (! $balance) {
                return null;
            }

            return BalanceMapper::fromModelToEntity($balance);

        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());

            throw new DatabaseException();
        }
    }
}
