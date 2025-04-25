<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupRecurringExpense extends Model
{
    protected $table = 'groups_recurring_expenses';

    protected $fillable = [
        'group_id',
        'recurring_expense_id',
    ];
}
