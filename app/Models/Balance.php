<?php

namespace App\Models;

use Database\Factories\BalanceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Balance extends Model
{
    /** @use HasFactory<BalanceFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'amount',
        'currency_id',
    ];

    /**
     * @return BelongsTo<User>
     */
    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<User>
     */
    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
