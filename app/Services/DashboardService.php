<?php

namespace App\Services;

use App;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\Models\Absence;
use Illuminate\Support\Collection;
use App\Repository\UserRepositoryInterface;
use App\Repository\AbsenceRepositoryInterface;
use App\Repository\WorkToggleRepositoryInterface;
use App\Repository\TimeReportRepositoryInterface;

class DashboardService
{
    private UserRepositoryInterface $userRepository;
    private AbsenceRepositoryInterface $absenceRepository;
    private WorkToggleRepositoryInterface $workToggleRepository;
    private TimeReportRepositoryInterface $timeReportRepository;

    function __construct(private int $userId, private string $month)
    {
        $this->userRepository = App::make(UserRepositoryInterface::class);
        $this->absenceRepository = App::make(AbsenceRepositoryInterface::class);
        $this->workToggleRepository = App::make(WorkToggleRepositoryInterface::class);
        $this->timeReportRepository = App::make(TimeReportRepositoryInterface::class);
    }

    public function getTableData()
    {
        $dateRange = $this->dateRange();
        $absences = $this->getAbsences($dateRange);
        $workToggles = $this->getWorkToggles($dateRange);
        $timeReports = $this->getTimeReports($dateRange);
        $paymentFactorySummary = 0;

        $tableData = $dateRange->transform(function ($date) use ($absences, $workToggles, $timeReports, &$paymentFactorySummary): array {
            $dayToggles = $this->dayTogglesData($workToggles, $date);
            $dayTimeReports = $this->dayTimeReportsData($timeReports, $date);
            $reportSummary = $this->parseSecondsToHuman($dayTimeReports['summaryInSeconds']);
            $paymentFactory = $this->getPaymentFactory($dayTimeReports['summaryInSeconds']);
            $totalGap = $this->getTotalGap($dayToggles['entrance']?->diffInSeconds($dayToggles['exit']), $dayTimeReports['summaryInSeconds']);

            if (!is_null($paymentFactory)) {
                $paymentFactorySummary += $paymentFactory['work'] + $paymentFactory['break'];
            }

            return [
                'date' => $date->format('d / l'),
                'isAbsent' => $absences->contains($date),
                'isWeekend' => $date->isWeekend(),
                'entrance' => $dayToggles['entrance']?->format('H:i'),
                'exit' => $dayToggles['exit']?->format('H:i'),
                'inOfficeSummary' => $dayToggles['inOfficeSummary'],
                'start' => $dayTimeReports['start']?->format('H:i'),
                'end' => $dayTimeReports['end']?->format('H:i'),
                'reportSummary' => $reportSummary,
                'paymentFactory' => is_null($paymentFactory) ? null : "{$paymentFactory['work']} + {$paymentFactory['break']}",
                'totalGap' => $totalGap,
            ];
        });

        return [
            'table' => $tableData,
            'summary' => [
                'inOfficeSummary' => $this->getInOfficeSummary($workToggles),
                'reportSummary' => $this->getReportSummary($timeReports),
                'paymentFactory' => $paymentFactorySummary,
            ]
        ];
    }

    private function dayTogglesData(Collection $workToggles, Carbon $date): array
    {
        $dayToggles = $workToggles->get($date->format('d'));
        $entrance = $dayToggles?->first()->date_time;
        $exit = $dayToggles?->last()->date_time;
        $data = ['entrance' => $entrance, 'exit' => $exit, 'inOfficeSummary' => null];
        if (is_null($entrance) && is_null($exit)) return $data;

        $data['inOfficeSummary'] = $this->parseSecondsToHuman($entrance->diffInSeconds($exit));
        return $data;
    }

    private function dayTimeReportsData(Collection $timeReports, Carbon $date): array
    {
        $dayTimeReports = $timeReports->get($date->format('d'));
        $start = $dayTimeReports?->first()->start_time;
        $end = $dayTimeReports?->last()->end_time;
        $data = ['start' => $start, 'end' => $end, 'summaryInSeconds' => null];
        if (is_null($dayTimeReports)) return $data;

        $data['summaryInSeconds'] = $dayTimeReports->reduce(function ($carry, $timeReport) {
            return $carry + $timeReport->start_time->diffInSeconds($timeReport->end_time);
        });
        return $data;
    }

    private function dateRange($startTime=null, $endTime=null): Collection
    {
        if (is_null($startTime) && is_null($endTime)) {
            $date = Carbon::createFromFormat('Y-m', $this->month);
            $start = new Carbon($date->startOfMonth());
            $end = new Carbon($date->endOfMonth());
        } else {
            $start = new Carbon($startTime->startOfDay());
            $end = new Carbon($endTime->endOfDay());
        }

        return new Collection(new DatePeriod($start, new DateInterval('P1D'), $end));
    }

    private function getAbsences(Collection $dateRange): Collection
    {
        $start = $dateRange->first()->startOfDay();
        $end = $dateRange->last()->endOfDay();

        return $this->absenceRepository
            ->getForPeriod($this->userId, $start, $end)
            ->where('status', Absence::STATUS['accepted'])
            ->flatMap(fn ($absence) => $this->dateRange($absence->start_time, $absence->end_time));
    }

    private function getWorkToggles(Collection $dateRange): Collection
    {
        $start = $dateRange->first()->startOfDay();
        $end = $dateRange->last()->endOfDay();

        return $this->workToggleRepository
            ->getForPeriod($this->userId, $start, $end)
            ->groupBy(fn ($toggle) => Carbon::parse($toggle->date_time)->format('d'));
    }

    private function getTimeReports(Collection $dateRange): Collection
    {
        $start = $dateRange->first()->startOfDay();
        $end = $dateRange->last()->endOfDay();
        
        return $this->timeReportRepository
            ->getForPeriod($this->userId, $start, $end)
            ->where('removed', false)
            ->groupBy(fn ($timeReport) => Carbon::parse($timeReport->start_time)->format('d'));
    }

    private function getPaymentFactory(?int $total): ?array
    {
        if (is_null($total)) return null;

        $work = $total / 3600;
        $break = $work <= 7.5 ? ($work / 7.5) * 0.5 : 0.5;
        return [
            'work' => round($work, 1),
            'break' => round($break, 1),
        ];
    }

    private function getTotalGap(?int $inOfficeSummary, ?int $reportSummary): ?string
    {
        if ($inOfficeSummary <= 0) return null;
        if ($reportSummary <= 0) return null;

        $gap = abs($inOfficeSummary - $reportSummary);
        $percent = round(($gap * 100) / $reportSummary, 0);
        $time = $this->parseSecondsToHuman($gap);
        return "{$time} ({$percent}%)";
    }

    private function getInOfficeSummary(Collection $workToggles): string
    {
        $workTogglesSummary = $workToggles->reduce(function ($carry, $workToggle) {
            $start = $workToggle->first()->date_time;
            $end = $workToggle->last()->date_time;
            return $carry + $start->diffInSeconds($end);
        });

        return $this->parseSecondsToHuman($workTogglesSummary);
    }

    private function getReportSummary(Collection $timeReports): string
    {
        $timeReportsSummary = $timeReports->flatten()->reduce(function ($carry, $timeReport) {
            return $carry + $timeReport->start_time->diffInSeconds($timeReport->end_time);
        });

        return $this->parseSecondsToHuman($timeReportsSummary);
    }

    private function parseSecondsToHuman($time): ?string
    {
        if (is_null($time)) return null;

        $carbonInterval = CarbonInterval::seconds($time)->cascade();
        $hours = floor($carbonInterval->totalHours);
        $minutes = floor($carbonInterval->totalMinutes) - ($hours * CarbonInterval::getMinutesPerHour());
        return "{$hours}h {$minutes}min";
    }
}
