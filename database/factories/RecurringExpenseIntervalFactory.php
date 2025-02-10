<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\RecurringExpense;
use App\Models\RecurringExpenseInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RecurringExpenseInterval>
 */
class RecurringExpenseIntervalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $recurringExpense = RecurringExpense::factory()->create();

        return [
            'recurring_expense_id' => $recurringExpense->id,
            'interval'             => fake()->numberBetween(1, $recurringExpense->intervals),
            'expense_id'           => Expense::factory()->create([
                'amount'      => $recurringExpense->amount / $recurringExpense->intervals,
                'currency_id' => $recurringExpense->currency_id,
            ])->id,
        ];
    }
}
