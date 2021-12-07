<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', fn(): View => view('homepage'));
Route::post('/login', [AuthController::class, 'authentication'])->name('auth-login');

Route::resource('dashboard', DashboardController::class)->only('index');
