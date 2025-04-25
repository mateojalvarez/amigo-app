<?php

namespace App\Models;

use Database\Factories\ExpensePayeeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpensePayee extends Model
{
    /** @use HasFactory<ExpensePayeeFactory> */
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'expense_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
