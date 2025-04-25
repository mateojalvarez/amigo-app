<?php

namespace Tests\Integration\Expense\Infrastructure\Database\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Src\Expense\Domain\Entities\RecurringExpenseEntity;
use Src\Expense\Domain\Enums\ExpenseCategoryEnum;
use Src\Expense\Domain\Enums\RecurringTypeEnum;
use Src\Expense\Domain\Repositories\RecurringExpenseRepository;
use Src\Expense\Domain\ValueObjects\ExpenseDescription;
use Src\Expense\Domain\ValueObjects\ExpenseListIdentifier;
use Src\Expense\Domain\ValueObjects\Lists\ParticipantsList;
use Src\Expense\Domain\ValueObjects\UserUuid;
use Src\Shared\Enums\CurrencyEnum;
use Src\Shared\Exceptions\DatabaseException;
use Src\Shared\ValueObjects\Amount;
use Tests\TestCase;

/**
 * @internal
 */
class RecurringExpenseEloquentRepositoryTest extends TestCase
{
    private RecurringExpenseRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->app->make(RecurringExpenseRepository::class);
    }

    public function test_it_should_save_a_recurring_expense(): void
    {
        $recurringExpense = $this->getRecurringExpense();

        $this->repository->save(
            $recurringExpense
        );

        $this->assertDatabaseHas('recurring_expenses', [
            'uuid'                => $recurringExpense->getUuid(),
            'intervals'           => $recurringExpense->getTotalIntervals(),
            'total_amount'        => $recurringExpense->getTotalAmount()->getValue() / 100,
            'currency_id'         => $recurringExpense->getTotalAmount()->getCurrency()->value,
            'recurring_type_id'   => $recurringExpense->getRecurringType()->value,
            'expense_category_id' => $recurringExpense->getCategory()?->value,
            'description'         => $recurringExpense->getDescription()->value(),
            'start_date'          => $recurringExpense->getStartDate(),
        ]);
    }

    public function test_it_should_fail_by_unexisting_users(): void
    {
        $recurringExpense = $this->getRecurringExpenseMock();

        $this->expectException(DatabaseException::class);

        $this->repository->save(
            $recurringExpense
        );

        $this->assertDatabaseMissing('recurring_expenses', [
            'uuid'                => $recurringExpense->getUuid(),
            'intervals'           => $recurringExpense->getTotalIntervals(),
            'total_amount'        => $recurringExpense->getTotalAmount()->getValue() / 100,
            'currency_id'         => $recurringExpense->getTotalAmount()->getCurrency()->value,
            'recurring_type_id'   => $recurringExpense->getRecurringType()->value,
            'expense_category_id' => $recurringExpense->getCategory()?->value,
            'description'         => $recurringExpense->getDescription()->value(),
            'start_date'          => $recurringExpense->getStartDate(),
        ]);
    }

    public function test_should_get_list_successfully(): void
    {
        $recurringExpense = $this->getRecurringExpense();

        $this->repository->save(
            $recurringExpense
        );

        $listIdentifier = new ExpenseListIdentifier(
            new UserUuid(
                $recurringExpense->getPayers()->getParticipants()[0]->value()
            ),
        );

        $recurringExpenses = $this->repository->getList($listIdentifier);

        $this->assertNotEmpty($recurringExpenses->getExpenses());

        $this->assertContainsOnlyInstancesOf(RecurringExpenseEntity::class, $recurringExpenses->getExpenses());

        $this->assertEquals($recurringExpense->getUuid(), $recurringExpenses->getExpenses()[0]->getUuid());
    }

    private function getRecurringExpense(): RecurringExpenseEntity
    {
        $recurringExpense = new RecurringExpenseEntity(
            $this->getParticipantsList(),
            $this->getParticipantsList(),
            $this->getAmount(),
            Carbon::now(),
            new ExpenseDescription(
                'Description'
            ),
            RecurringTypeEnum::MONTHLY,
            12
        );

        $recurringExpense->generateUuid();

        if (fake()->boolean()) {
            $recurringExpense->setCategory(
                fake()->randomElement(ExpenseCategoryEnum::cases())->value
            );
        }

        return $recurringExpense;
    }

    private function getRecurringExpenseMock(): RecurringExpenseEntity
    {
        $recurringExpense = new RecurringExpenseEntity(
            $this->getParticipantsListMock(),
            $this->getParticipantsListMock(),
            $this->getAmount(),
            Carbon::now(),
            new ExpenseDescription(
                'Description'
            ),
            RecurringTypeEnum::MONTHLY,
            12
        );

        $recurringExpense->generateUuid();

        return $recurringExpense;
    }

    private function getParticipantsList(): ParticipantsList
    {
        return new ParticipantsList([
            new UserUuid(
                User::factory()->create()->uuid
            ),
            new UserUuid(
                User::factory()->create()->uuid
            ),
        ]);
    }

    private function getParticipantsListMock(): ParticipantsList
    {
        return new ParticipantsList([
            new UserUuid(
                fake()->uuid()
            ),
            new UserUuid(
                fake()->uuid()
            ),
        ]);
    }

    private function getAmount(): Amount
    {
        return new Amount(
            1000,
            CurrencyEnum::from(840)
        );
    }
}
