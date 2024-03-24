<?php

namespace Funbox\Plugins\Registration\Routes;

use Funbox\Framework\Routing\Route;

function Web()
{
    Route::get('/register', [\Funbox\Plugins\Registration\Controllers\RegistrationController::class, 'index']);
    Route::post('/register', [\Funbox\Plugins\Registration\Controllers\RegistrationController::class, 'register']);
}

