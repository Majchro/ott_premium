<?php

namespace App\Repository\Eloquent;

use Carbon\Carbon;
use App\Models\Absence;
use App\Repository\AbsenceRepositoryInterface;
use Illuminate\Support\Collection;

class AbsenceRepository extends BaseRepository implements AbsenceRepositoryInterface
{
    public function __construct(Absence $model)
    {
        parent::__construct($model);
    }

    public function getForPeriod(int $userId, Carbon $start, Carbon $end): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->whereBetween('start_time', [$start, $end])
            ->get();
    }
}
