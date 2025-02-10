<?php

namespace Src\Expense\Infrastructure\Database\Repositories;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Src\Expense\Domain\Entities\ExpenseEntity;
use Src\Expense\Domain\Entities\Lists\ExpenseList;
use Src\Expense\Domain\Repositories\ExpenseRepository;
use Src\Expense\Domain\ValueObjects\ExpenseListIdentifier;
use Src\Expense\Infrastructure\Database\Mappers\ExpenseListMapper;
use Src\Shared\Exceptions\DatabaseException;
use Throwable;

class ExpenseEloquentRepository implements ExpenseRepository
{
    /**
     * @throws DatabaseException
     */
    public function save(ExpenseEntity $expenseEntity): void
    {
        try {

            $expenseModel = Expense::create([
                'uuid'                => $expenseEntity->getUuid(),
                'amount'              => $expenseEntity->getAmount()->getValue() / 100,
                'currency_id'         => $expenseEntity->getAmount()->getCurrency()->value,
                'description'         => $expenseEntity->getDescription()->value(),
                'expense_date'        => $expenseEntity->getExpenseDate(),
                'expense_category_id' => $expenseEntity->getCategory()?->value,
            ]);

            $expenseEntity->setId($expenseModel->id);

            foreach ($expenseEntity->getPayers()->getParticipants() as $payerUuid) {
                $expenseModel->payers()->create([
                    'user_id' => User::where('uuid', $payerUuid->value())->first()->id,
                ]);
            }

            foreach ($expenseEntity->getPayees()->getParticipants() as $payeeUuid) {
                $expenseModel->payees()->create([
                    'user_id' => User::where('uuid', $payeeUuid->value())->first()->id,
                ]);
            }

            if ($expenseEntity->getNote()) {
                $expenseModel->note()->create([
                    'note'    => $expenseEntity->getNote()->value(),
                    'user_id' => $expenseEntity->getNote()->userIdentifier()->getId(),
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
    public function getExpenseList(ExpenseListIdentifier $identifier): ExpenseList
    {
        try {

            $user = User::where('uuid', $identifier->getUserUuid()->value())->select('id')->first();

            $expenseList = Expense::whereHas('payees', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->orWhereHas('payers', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
                ->when($identifier->getGroupUuid(), function ($query) use ($identifier) {
                    $query->whereHas('group', function ($query) use ($identifier) {
                        $query->where('uuid', $identifier->getGroupUuid()->value());
                    });
                })
                ->when($identifier->getFromDate(), function ($query) use ($identifier) {
                    $query->where('expense_date', '<=', $identifier->getFromDate());
                })
                ->when($identifier->getCategory(), function ($query) use ($identifier) {
                    $query->where('expense_category_id', $identifier->getCategory()->value);
                })
                ->with([
                    'payees.user:id,uuid',
                    'payers.user:id,uuid',
                    'note.user:id,uuid',
                ])
                ->get();

            return ExpenseListMapper::fromCollectionToList($expenseList);

        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());

            throw new DatabaseException();
        }
    }
}
