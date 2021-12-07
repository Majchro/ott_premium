<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Absence extends Model
{
    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'status',
        'metadata',
        'removed_at',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'removed_at' => 'datetime',
    ];

    public const STATUS = [
        'fresh' => 0,
        'accepted' => 1,
        'rejected' => 2,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
