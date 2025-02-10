<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupExpense extends Pivot
{
    protected $table = 'groups_expenses';

    protected $fillable = [
        'group_id',
        'expense_id',
    ];
}
