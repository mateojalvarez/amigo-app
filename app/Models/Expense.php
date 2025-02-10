<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'amount',
        'currency_id',
        'description',
        'expense_date',
        'expense_category_id',
    ];

    /**
     * @return HasOne<ExpenseNote>
     */
    public function note(): HasOne
    {
        return $this->hasOne(ExpenseNote::class);
    }

    /**
     * @return HasMany<ExpensePayer>
     */
    public function payers(): HasMany
    {
        return $this->hasMany(ExpensePayer::class);
    }

    /**
     * @return HasMany<ExpensePayee>
     */
    public function payees(): HasMany
    {
        return $this->hasMany(ExpensePayee::class);
    }

    /**
     * @return HasOneThrough<Group>
     */
    public function group(): HasOneThrough
    {
        return $this->hasOneThrough(Group::class, GroupExpense::class);
    }
}
