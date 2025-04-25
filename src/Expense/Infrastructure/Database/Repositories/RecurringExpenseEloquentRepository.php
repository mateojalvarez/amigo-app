<?php

namespace Src\Expense\Infrastructure\Database\Repositories;

use App\Models\RecurringExpense;
use App\Models\RecurringExpenseInterval as RecurringExpenseIntervalModel;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Src\Expense\Domain\Entities\Lists\ExpenseList;
use Src\Expense\Domain\Entities\RecurringExpenseEntity;
use Src\Expense\Domain\Repositories\RecurringExpenseRepository;
use Src\Expense\Domain\ValueObjects\ExpenseListIdentifier;
use Src\Expense\Domain\ValueObjects\RecurringExpenseInterval;
use Src\Expense\Infrastructure\Database\Mappers\ExpenseListMapper;
use Src\Shared\Exceptions\DatabaseException;
use Throwable;

class RecurringExpenseEloquentRepository implements RecurringExpenseRepository
{
    /**
     * @throws DatabaseException
     */
    public function save(RecurringExpenseEntity $recurringExpenseEntity): void
    {
        try {

            $recurringExpenseModel = RecurringExpense::create([
                'uuid'                => $recurringExpenseEntity->getUuid(),
                'intervals'           => $recurringExpenseEntity->getTotalIntervals(),
                'total_amount'        => $recurringExpenseEntity->getTotalAmount()->getValue() / 100,
                'currency_id'         => $recurringExpenseEntity->getTotalAmount()->getCurrency()->value,
                'recurring_type_id'   => $recurringExpenseEntity->getRecurringType()->value,
                'expense_category_id' => $recurringExpenseEntity->getCategory()?->value,
                'description'         => $recurringExpenseEntity->getDescription()->value(),
                'start_date'          => $recurringExpenseEntity->getStartDate(),
            ]);

            $recurringExpenseEntity->setId($recurringExpenseModel->id);

            $payerUuids = array_map(fn ($payer) => $payer->value(), $recurringExpenseEntity->getPayers()->getParticipants());
            $payeeUuids = array_map(fn ($payee) => $payee->value(), $recurringExpenseEntity->getPayees()->getParticipants());

            $users = User::whereIn('uuid', array_merge($payerUuids, $payeeUuids))->get()->keyBy('uuid');

            foreach ($payerUuids as $payerUuid) {
                $recurringExpenseModel->payers()->create([
                    'user_id' => $users[$payerUuid]->id,
                ]);
            }

            foreach ($payeeUuids as $payeeUuid) {
                $recurringExpenseModel->payees()->create([
                    'user_id' => $users[$payeeUuid]->id,
                ]);
            }

        } catch (Throwable $th) {
            Log::error($th->getMessage());

            throw new DatabaseException();
        }
    }

    /**
     * @throws DatabaseException
     */
    public function saveInterval(RecurringExpenseInterval $interval): void
    {
        try {

            RecurringExpenseIntervalModel::create([
                'recurring_expense_id' => $interval->getRecurringExpenseId(),
                'expense_id'           => $interval->getExpenseId(),
                'interval'             => $interval->getInterval(),
            ]);

        } catch (Throwable $th) {
            Log::error($th->getMessage());

            throw new DatabaseException();
        }
    }

    /**
     * @throws DatabaseException
     */
    public function getList(ExpenseListIdentifier $identifier): ExpenseList
    {
        try {

            $user = User::where('uuid', $identifier->getUserUuid()->value())->select('id')->first();

            $recurringExpenses = RecurringExpense::whereHas('payees', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->orWhereHas('payers', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
                ->when($identifier->getGroupUuid(), function ($query) use ($identifier) {
                    $query->whereHas('group', function ($query) use ($identifier) {
                        $query->where('uuid', $identifier->getGroupUuid()?->value());
                    });
                })
                ->when($identifier->getFromDate(), function ($query) use ($identifier) {
                    $query->where('start_date', '<=', $identifier->getFromDate());
                })
                ->when($identifier->getCategory(), function ($query) use ($identifier) {
                    $query->where('expense_category_id', $identifier->getCategory()?->value);
                })
                ->with([
                    'payees.user:id,uuid',
                    'payers.user:id,uuid',
                ])
                ->get();

            return ExpenseListMapper::fromCollectionToList($recurringExpenses);

        } catch (Throwable $th) {
            Log::error($th->getMessage());

            throw new DatabaseException();
        }
    }
}
