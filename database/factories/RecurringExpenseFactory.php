<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Expense\Domain\Enums\RecurringTypeEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecurringExpense>
 */
class RecurringExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid'              => fake()->uuid(),
            'amount'            => fake()->randomFloat(2, 1, 1000) * 100,
            'currency_id'       => fake()->randomElement([32, 840]),
            'description'       => fake()->sentence(),
            'start_date'        => fake()->date(),
            'recurring_type_id' => fake()->randomElement(RecurringTypeEnum::cases())->value,
            'intervals'         => fake()->numberBetween(1, 12),
        ];
    }
}
