<?php

namespace Funbox\Framework\Routing;

class Cache
{
    public static function prepare()
    {
        require APP_PATH . 'routes' . DIRECTORY_SEPARATOR . 'Web.php';
    }
}