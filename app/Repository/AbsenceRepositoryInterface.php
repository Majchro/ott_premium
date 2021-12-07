<?php

namespace App\Repository;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface AbsenceRepositoryInterface {
    public function getForPeriod(int $userId, Carbon $start, Carbon $end): Collection;
}
