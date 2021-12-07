<?php

namespace App\Repository\Eloquent;

use Carbon\Carbon;
use App\Models\TimeReport;
use Illuminate\Support\Collection;
use App\Repository\TimeReportRepositoryInterface;

class TimeReportRepository extends BaseRepository implements TimeReportRepositoryInterface
{
    public function __construct(TimeReport $model)
    {
        parent::__construct($model);
    }

    public function getForPeriod(int $userId, Carbon $start, Carbon $end): Collection
      {
          return $this->model
              ->where('user_id', $userId)
              ->whereBetween('start_time', [$start, $end])
              ->whereBetween('end_time', [$start, $end])
              ->get();
      }
}
