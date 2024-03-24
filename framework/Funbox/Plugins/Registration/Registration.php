<?php

namespace Funbox\Plugins\Registration;

use Funbox\Framework\Routing\Route;

class Registration
{
    public static function viewsPaths(): array
    {
        return [
            PLUGINS_PATH . 'Registration' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR
        ];
    }

    public static function routes()
    {
        Route::get('/register', [\Funbox\Plugins\Registration\Controllers\RegistrationController::class, 'index']);
        Route::post('/register', [\Funbox\Plugins\Registration\Controllers\RegistrationController::class, 'register']);
    }
}