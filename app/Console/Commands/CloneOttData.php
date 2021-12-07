<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use App\Repository\AbsenceRepositoryInterface;
use App\Repository\TimeReportRepositoryInterface;
use App\Repository\WorkToggleRepositoryInterface;

class CloneOttData extends Command
{
    protected $signature = 'clone:ott_data';
    protected $description = 'Clone data from OTT dump';

    public function __construct(
        private TimeReportRepositoryInterface $timeReportRepository,
        private AbsenceRepositoryInterface $absenceRepository,
        private WorkToggleRepositoryInterface $workToggleRepository
    )
    {
        parent::__construct();
    }

    public function handle()
    {
        // $this->timeReports();
        // $this->absences();
        $this->userRfids();
        return Command::SUCCESS;
    }

    private function timeReports()
    {
        DB::connection('ott_dump')
            ->table('time_reports')
            ->select('*')
            ->where('id', '>=', 100000)
            ->orderBy('created_at')
            ->lazy()
            ->each(function ($report) {
                var_dump($report->id);
                $userId = $report->user_id === 94 ? 1 : rand(2, 11);
                if (!$report->end_time) return var_dump('pass');

                $this->timeReportRepository->create([
                    'start_time' => $report->start_time,
                    'end_time' => $report->end_time,
                    'user_id' => $userId,
                    'task_id' => 1,
                    'removed' => $report->removed,
                    'created_at' => $report->created_at,
                    'updated_at' => $report->updated_at,
                ]);
            });
    }

    private function absences()
    {
        DB::connection('ott_dump')
            ->table('absences')
            ->select('*')
            ->orderBy('created_at')
            ->lazy()
            ->each(function ($absence) {
                var_dump($absence->id);
                $userId = $absence->user_id === 94 ? 1 : rand(2, 11);

                $this->absenceRepository->create([
                    'user_id' => $userId,
                    'start_time' => $absence->start_time,
                    'end_time' => $absence->end_time,
                    'status' => $absence->status,
                    'metadata' => $absence->metadata,
                    'removed_at' => $absence->removed_at,
                    'created_at' => $absence->created_at,
                    'updated_at' => $absence->updated_at,
                ]);
            });
    }

    private function userRfids()
    {
        DB::connection('ott_dump')
            ->table('user_rfids')
            ->select('*')
            ->orderBy('id')
            ->lazy()
            ->each(function ($userRfid) {
                var_dump($userRfid->id);
                $userId = $userRfid->user_id === 94 ? 1 : rand(2, 11);

                $this->workToggleRepository->create([
                    'user_id' => $userId,
                    'date_time' => $userRfid->date_time,
                ]);
            });
    }
}
