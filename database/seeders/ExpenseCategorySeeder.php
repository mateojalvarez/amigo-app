<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Src\Expense\Domain\Enums\ExpenseCategoryEnum;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (ExpenseCategoryEnum::cases() as $category) {
            DB::table('expense_categories')->insert([
                'id'   => $category->value,
                'name' => strtolower($category->name),
            ]);
        }
    }
}
