<?php

use Funbox\Framework\Routing\Route;

Route::get('/register', [\Funbox\Plugins\Authentication\Controllers\RegistrationController::class, 'index']);
Route::post('/register', [\Funbox\Plugins\Authentication\Controllers\RegistrationController::class, 'register']);

