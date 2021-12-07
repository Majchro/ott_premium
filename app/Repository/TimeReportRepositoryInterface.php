<?php

namespace App\Repository;

use Carbon\Carbon;
use Illuminate\Support\Collection;


interface TimeReportRepositoryInterface {
    public function getForPeriod(int $userId, Carbon $start, Carbon $end): Collection;
}
