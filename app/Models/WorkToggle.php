<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class WorkToggle extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'date_time',
    ];

    protected $casts = [
        'date_time' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
