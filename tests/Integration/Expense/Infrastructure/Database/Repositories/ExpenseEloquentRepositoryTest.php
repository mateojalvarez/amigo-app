<?php

namespace Tests\Integration\Expense\Infrastructure\Database\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Src\Expense\Domain\Entities\ExpenseEntity;
use Src\Expense\Domain\Enums\ExpenseCategoryEnum;
use Src\Expense\Domain\Exceptions\InvalidDescriptionLengthException;
use Src\Expense\Domain\Exceptions\InvalidNoteLengthException;
use Src\Expense\Domain\Repositories\ExpenseRepository;
use Src\Expense\Domain\ValueObjects\ExpenseDescription;
use Src\Expense\Domain\ValueObjects\ExpenseListIdentifier;
use Src\Expense\Domain\ValueObjects\Lists\ParticipantsList;
use Src\Expense\Domain\ValueObjects\UserIdentifier;
use Src\Expense\Domain\ValueObjects\UserUuid;
use Src\Shared\Enums\CurrencyEnum;
use Src\Shared\Exceptions\DatabaseException;
use Src\Shared\ValueObjects\Amount;
use Tests\TestCase;

/**
 * @internal
 */
class ExpenseEloquentRepositoryTest extends TestCase
{
    private ExpenseRepository $repository;

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->app->make(ExpenseRepository::class);
    }

    /**
     * @throws InvalidDescriptionLengthException
     * @throws InvalidNoteLengthException
     */
    public function test_it_should_save_an_expense(): void
    {
        $expense = $this->getExpense();

        $this->repository->save(
            $expense
        );

        $this->assertDatabaseHas('expenses', [
            'uuid'                => $expense->getUuid(),
            'amount'              => $expense->getAmount()->getValue() / 100,
            'currency_id'         => $expense->getAmount()->getCurrency()->value,
            'description'         => $expense->getDescription()->value(),
            'expense_date'        => $expense->getExpenseDate(),
            'expense_category_id' => $expense->getCategory()?->value,
        ]);
    }

    /**
     * @throws InvalidDescriptionLengthException
     */
    public function test_it_should_fail_by_unexisting_users(): void
    {
        $expense = $this->getExpenseMock();

        $this->expectException(DatabaseException::class);

        $this->repository->save(
            $expense
        );

        $this->assertDatabaseMissing('expenses', [
            'uuid'                => $expense->getUuid(),
            'amount'              => $expense->getAmount()->getValue() / 100,
            'currency_id'         => $expense->getAmount()->getCurrency()->value,
            'description'         => $expense->getDescription()->value(),
            'expense_date'        => $expense->getExpenseDate(),
            'expense_category_id' => $expense->getCategory()?->value,
        ]);
    }

    /**
     * @throws InvalidNoteLengthException
     * @throws InvalidDescriptionLengthException
     */
    public function test_should_get_expense_list_successfully(): void
    {
        $expense = $this->getExpense();

        $this->repository->save(
            $expense
        );

        $expenseListIdentifier = new ExpenseListIdentifier(
            new UserUuid(
                $expense->getPayers()->getParticipants()[0]->value()
            ),
            null,
            null,
            null
        );

        $expenseList = $this->repository->getExpenseList($expenseListIdentifier);

        $this->assertNotEmpty($expenseList->getExpenses());

        $this->assertEquals($expense->getUuid(), $expenseList->getExpenses()[0]->getUuid());
    }

    /**
     * @throws InvalidNoteLengthException
     * @throws InvalidDescriptionLengthException
     */
    private function getExpense(): ExpenseEntity
    {
        $expense = new ExpenseEntity(
            $this->getParticipantsList(),
            $this->getParticipantsList(),
            $this->getAmount(),
            Carbon::parse('2021-10-10 23:00:00'),
            new ExpenseDescription(
                substr(fake()->sentence(), 0, 50)
            )
        );

        $expense->generateUuid();

        $this->fillExpense($expense);

        return $expense;
    }

    /**
     * @throws InvalidDescriptionLengthException
     */
    private function getExpenseMock(): ExpenseEntity
    {
        $expense = new ExpenseEntity(
            $this->getParticipantsListMock(),
            $this->getParticipantsListMock(),
            $this->getAmount(),
            Carbon::parse('2021-10-10 23:00:00'),
            new ExpenseDescription(
                substr(fake()->sentence(), 0, 50)
            )
        );

        $expense->generateUuid();

        return $expense;
    }

    /**
     * @throws InvalidNoteLengthException
     */
    private function fillExpense(ExpenseEntity $expense): void
    {
        if (fake()->boolean()) {
            $expense->setCategory(
                fake()->randomElement(ExpenseCategoryEnum::cases())->value
            );
        }

        if (fake()->boolean()) {

            $user = User::factory()->create();

            $expense->setNote(
                substr(fake()->sentence(), 0, 255),
                new UserIdentifier(
                    $user->id,
                    new UserUuid($user->uuid)
                )
            );
        }
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
