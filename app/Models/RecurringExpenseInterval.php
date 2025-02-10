<?php

namespace App\Models;

use Database\Factories\RecurringExpenseIntervalFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecurringExpenseInterval extends Model
{
    /** @use HasFactory<RecurringExpenseIntervalFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'recurring_expense_id',
        'interval',
        'expense_id',
    ];
}
