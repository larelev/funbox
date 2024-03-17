<?php

return [
    ['GET', '/', [\App\Controllers\HomeController::class, 'index']],
    ['GET', '/posts/{id:\d+}', [\App\Controllers\PostController::class, 'show']],
    ['GET', '/posts', [\App\Controllers\PostController::class, 'create']],
    ['POST', '/posts', [\App\Controllers\PostController::class, 'store']],
    ['GET', '/hello/{name:.*}', function (string $name) {
        return new \Funbox\Framework\Http\Response(content: <<<HTML
            Hello $name!
            HTML);
    }]
];
