<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecurringExpense extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'intervals',
        'total_amount',
        'currency_id',
        'recurring_type_id',
        'expense_category_id',
        'description',
        'start_date',
    ];

    /**
     * @return HasMany<RecurringExpensePayer>
     */
    public function payers(): HasMany
    {
        return $this->hasMany(RecurringExpensePayer::class);
    }

    /**
     * @return HasMany<RecurringExpensePayee>
     */
    public function payees(): HasMany
    {
        return $this->hasMany(RecurringExpensePayee::class);
    }

    /**
     * @return HasOneThrough<Group>
     */
    public function group(): HasOneThrough
    {
        return $this->hasOneThrough(Group::class, 'groups_recurring_expenses');
    }
}
