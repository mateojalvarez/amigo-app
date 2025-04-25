<?php

namespace App\Models;

use Database\Factories\RecurringExpensePayerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecurringExpensePayer extends Model
{
    /** @use HasFactory<RecurringExpensePayerFactory> */
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'recurring_expense_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
