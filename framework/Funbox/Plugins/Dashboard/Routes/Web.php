<?php

use Funbox\Framework\Routing\Route;

Route::get('/dashboard', [\Funbox\Plugins\Dashboard\Controllers\DashboardController::class, 'index']);
