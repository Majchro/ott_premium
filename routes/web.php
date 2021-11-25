<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

Route::get('/', fn(): View => view('homepage'));
