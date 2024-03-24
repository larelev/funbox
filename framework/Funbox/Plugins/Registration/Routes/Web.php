<?php

use Funbox\Framework\Routing\Route;

Route::get('/register', [\Funbox\Plugins\Registration\Controllers\RegistrationController::class, 'index']);
Route::post('/register', [\Funbox\Plugins\Registration\Controllers\RegistrationController::class, 'register']);

