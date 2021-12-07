<?php

namespace App\Repository\Eloquent;

use Carbon\Carbon;
use App\Models\WorkToggle;
use Illuminate\Support\Collection;
use App\Repository\WorkToggleRepositoryInterface;

class WorkToggleRepository extends BaseRepository implements WorkToggleRepositoryInterface
{
    public function __construct(WorkToggle $model)
    {
        parent::__construct($model);
    }

    public function getForPeriod(int $userId, Carbon $start, Carbon $end): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->whereBetween('date_time', [$start, $end])
            ->get();
    }
}
