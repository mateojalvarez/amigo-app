<?php

namespace App\Providers\Contexts\Expense;

use Illuminate\Support\ServiceProvider;
use Src\Expense\Domain\Repositories\ExpenseRepository;
use Src\Expense\Domain\Repositories\RecurringExpenseRepository;
use Src\Expense\Infrastructure\Database\Repositories\ExpenseEloquentRepository;
use Src\Expense\Infrastructure\Database\Repositories\RecurringExpenseEloquentRepository;

class ExpenseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ExpenseRepository::class,
            ExpenseEloquentRepository::class
        );

        $this->app->bind(
            RecurringExpenseRepository::class,
            RecurringExpenseEloquentRepository::class
        );
    }
}
