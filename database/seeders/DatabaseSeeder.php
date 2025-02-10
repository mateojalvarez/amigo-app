<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RecurringTypeSeeder::class,
            CurrencySeeder::class,
            ExpenseCategorySeeder::class,
        ]);

        if (app()->environment('local')) {
            $this->askForSeedSampleData();
        }
    }

    protected function askForSeedSampleData(): void
    {
        if ($this->command->confirm('Would you like to add test data?')) {
            $this->call(UserSeeder::class);
            $this->command->info('Test data added!');
        }
    }
}
