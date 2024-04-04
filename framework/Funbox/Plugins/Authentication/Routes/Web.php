<?php

use Funbox\Framework\Routing\Route;

Route::get('/register', [\Funbox\Plugins\Authentication\Controllers\RegistrationController::class, 'index',
    [
        \Funbox\Plugins\Authentication\Middlewares\Guest::class,
    ]]);
Route::post('/register', [\Funbox\Plugins\Authentication\Controllers\RegistrationController::class, 'register']);
Route::get('/login', [\Funbox\Plugins\Authentication\Controllers\LoginController::class, 'index',
    [
        \Funbox\Plugins\Authentication\Middlewares\Guest::class,
    ],
]);
Route::post('/login', [\Funbox\Plugins\Authentication\Controllers\LoginController::class, 'login']);
Route::get('/logout', [\Funbox\Plugins\Authentication\Controllers\LoginController::class, 'logout',
    [
        \Funbox\Plugins\Authentication\Middlewares\Authentication::class,
    ],
]);
