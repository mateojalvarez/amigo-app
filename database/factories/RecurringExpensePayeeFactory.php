<?php

namespace Database\Factories;

use App\Models\RecurringExpense;
use App\Models\RecurringExpensePayee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RecurringExpensePayee>
 */
class RecurringExpensePayeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'recurring_expense_id' => RecurringExpense::factory()->create()->id,
            'user_id'              => User::factory()->create()->id,
        ];
    }
}
