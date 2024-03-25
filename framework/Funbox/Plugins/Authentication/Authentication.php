<?php

namespace Funbox\Plugins\Authentication;

use Funbox\Framework\Routing\Route;

class Authentication
{
    public static function viewsPaths(): array
    {
        return [
            PLUGINS_PATH . 'Authentication' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR
        ];
    }

    public static function routes()
    {
        include __DIR__ . DIRECTORY_SEPARATOR . 'Routes' . DIRECTORY_SEPARATOR . 'Web.php';
    }
}