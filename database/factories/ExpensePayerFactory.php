<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\ExpensePayer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExpensePayer>
 */
class ExpensePayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'expense_id' => Expense::factory()->create()->id,
            'user_id'    => User::factory()->create()->id,
        ];
    }
}
