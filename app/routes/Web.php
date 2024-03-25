<?php

use Funbox\Framework\Routing\Route;
use Funbox\Plugins\Authentication\Authentication;

Route::get('/', [\App\Controllers\HomeController::class, 'index']);
Route::get('/posts/{id:\d+}', [\App\Controllers\PostController::class, 'show']);
Route::get('/posts', [\App\Controllers\PostController::class, 'create']);
Route::post('/posts', [\App\Controllers\PostController::class, 'store']);
Route::get('/hello/{name:.*}', function (string $name) {
    return new \Funbox\Framework\Http\Response(content: <<<HTML
    Hello $name!
    HTML);
});

Authentication::routes();