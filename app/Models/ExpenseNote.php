<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpenseNote extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'expense_id',
        'user_id',
        'note',
    ];

    /**
     * @return BelongsTo<Expense, ExpenseNote>
     */
    public function expense(): BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }

    /**
     * @return BelongsTo<User, ExpenseNote>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
