<?php

namespace Funbox\Plugins\Authentication;

use League\Container\DefinitionContainerInterface;

class Authentication
{
    public const AUTH_KEY = 'auth_id';

    public static function viewsPaths(): array
    {
        return [
            PLUGINS_PATH . 'Authentication' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR
        ];
    }

    public static function routes(): void
    {
        include __DIR__ . DIRECTORY_SEPARATOR . 'Routes' . DIRECTORY_SEPARATOR . 'Web.php';
    }
}