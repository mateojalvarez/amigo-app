<?php

namespace Database\Factories;

use App\Models\TwoFactorAuthKey;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TwoFactorAuthKey>
 */
class TwoFactorAuthKeyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'secret'  => fake()->uuid(),
        ];
    }
}
