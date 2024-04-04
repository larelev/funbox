<?php

use Funbox\Framework\Routing\Route;
use Funbox\Plugins\Authentication\Authentication;
use Funbox\Plugins\Dashboard\Dashboard;

Route::get('/', [\App\Controllers\HomeController::class, 'index']);
Route::get('/posts/{id:\d+}', [\App\Controllers\PostController::class, 'show',
    [
        \Funbox\Plugins\Authentication\Middlewares\Authentication::class,
    ]]);
Route::get('/posts', [\App\Controllers\PostController::class, 'create',
    [
        \Funbox\Plugins\Authentication\Middlewares\Authentication::class,
    ]]);
Route::post('/posts', [\App\Controllers\PostController::class, 'store',
    [
        \Funbox\Plugins\Authentication\Middlewares\Authentication::class,
    ]]);
Route::get('/hello/{name:.*}', function (string $name) {
    return new \Funbox\Framework\Http\Response(content: <<<HTML
    Hello $name!
    HTML);
});

Authentication::routes();
Dashboard::routes();
