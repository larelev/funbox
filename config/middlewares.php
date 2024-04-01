<?php

return [
    \Funbox\Framework\Middleware\ExtractRouteInfo::class,
    \Funbox\Framework\Middleware\SessionManager::class,
    \Funbox\Plugins\Authentication\Middlewares\VerifyCsrfToken::class,
    \Funbox\Plugins\FlashMessage\Middlewares\FlashMessenger::class,
    \Funbox\Framework\Middleware\History::class,
    \Funbox\Framework\Middleware\RouterDispatcher::class,
];