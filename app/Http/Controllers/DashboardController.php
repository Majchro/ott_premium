<?php

namespace App\Http\Controllers;

use App\Http\Requests\DashboardRequest;
use Auth;
use App\Repository\UserRepositoryInterface;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function index(DashboardRequest $request)
    {
        $filters = $request->safe();
        $users = $this->userRepository->all();

        $dashboardService = new DashboardService($request->user, $request->month);
        $tableData = $dashboardService->getTableData();

        return view('dashboard', [
            'users' => $users,
            'filters' => $filters,
            'tableData' => $tableData,
        ]);
    }

    public function wrongdoings()
    {
        return view('wrongdoings');
    }
}
