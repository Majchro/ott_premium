<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Task;

class TimeReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_id',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ]

    public function user(): BelongsTo
    {
        $this->belongsTo(User::class);
    }

    public function task(): BelongsTo
    {
        $this->belongsTo(Task::class);
    }
}
