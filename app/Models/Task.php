<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\TimeReport;

class Task extends Model
{
    protected $fillable = [
        'name',
    ];

    public function timeReports(): HasMany
    {
        return $this->hasMany(TimeReport::class);
    }
}
