<?php

return [
    ['GET', '/', [\App\Controllers\HomeController::class, 'index']],
    ['GET', '/posts/{id:\d+}', [\App\Controllers\PostController::class, 'show']],
];
