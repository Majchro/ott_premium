<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\TimeReport;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function timeReports(): HasMany
    {
        $this->hasMany(TimeReport::class);
    }
}
