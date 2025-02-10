<?php

namespace Database\Factories;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Expense\Domain\Enums\ExpenseCategoryEnum;

/**
 * @extends Factory<Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid'         => fake()->uuid(),
            'amount'       => fake()->randomFloat(2, 1, 1000) * 100,
            'currency_id'  => fake()->randomElement([32, 840]),
            'description'  => substr(fake()->sentence(), 0, 50),
            'expense_date' => fake()->date(),
        ];
    }

    public function withCategory(ExpenseCategoryEnum $category): Factory
    {
        return $this->state([
            'expense_category_id' => $category->value,
        ]);
    }
}
