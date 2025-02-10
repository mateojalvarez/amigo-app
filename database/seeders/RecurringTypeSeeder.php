<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Src\Expense\Domain\Enums\RecurringTypeEnum;

class RecurringTypeSeeder extends Seeder
{
    public function run(): void
    {
        foreach (RecurringTypeEnum::cases() as $recurringType) {
            DB::table('recurring_types')->insert([
                'id'   => $recurringType->value,
                'name' => $recurringType->name,
            ]);
        }
    }
}
