<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TwoFactorAuthKey extends Model
{
    use SoftDeletes, HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'secret',
    ];
}
