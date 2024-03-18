<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Url extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'original_url',
        'shortened_url',
        'user_id'
    ];

    public const ACTIVE = 1;
    public const INACTIVE = 1;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
