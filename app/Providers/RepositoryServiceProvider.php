<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\UserRepositoryInterface;
use App\Repository\Eloquent\UserRepository;
use App\Repository\TimeReportRepositoryInterface;
use App\Repository\Eloquent\TimeReportRepository;
use App\Repository\AbsenceRepositoryInterface;
use App\Repository\Eloquent\AbsenceRepository;
use App\Repository\WorkToggleRepositoryInterface;
use App\Repository\Eloquent\WorkToggleRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TimeReportRepositoryInterface::class, TimeReportRepository::class);
        $this->app->bind(AbsenceRepositoryInterface::class, AbsenceRepository::class);
        $this->app->bind(WorkToggleRepositoryInterface::class, WorkToggleRepository::class);
    }
}
