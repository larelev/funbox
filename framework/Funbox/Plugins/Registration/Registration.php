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
        include __DIR__ . DIRECTORY_SEPARATOR . 'Routes' . DIRECTORY_SEPARATOR . 'Web.php';
    }
}