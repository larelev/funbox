<?php

namespace Funbox\Framework\Routing;

use Funbox\Framework\Caching\Cache;
use Funbox\Framework\Utils\Misc;

class RoutesAggregator
{
    public const ROUTES_JSON_PATH = Cache::CACHE_PATH . 'routes.json';
    public const ROUTES_PATH = Cache::CACHE_PATH . 'routes.php';

    function aggregate(string $method, string $route, array|callable $controller): void
    {
        if(file_exists(self::ROUTES_PATH)) {
            return;
        }
        $this->prepareCacheIfNotExists();

        $json = file_get_contents(self::ROUTES_JSON_PATH);

        $routes = json_decode($json, JSON_OBJECT_AS_ARRAY);

        $routes[] = [$method, $route, $controller];

        $json = json_encode($routes, JSON_PRETTY_PRINT);

        file_put_contents(self::ROUTES_JSON_PATH, $json);
    }

    private function prepareCacheIfNotExists(): void
    {
        if(file_exists(self::ROUTES_JSON_PATH)) {
            return;
        }

        if(!touch(self::ROUTES_JSON_PATH)) {
            throw new \RuntimeException('Impossible to write ' . self::ROUTES_JSON_PATH . ' file.');
        }

        file_put_contents(self::ROUTES_JSON_PATH, '[]');
    }

    public static function writeRuntimeFile()
    {
        $json = file_get_contents(self::ROUTES_JSON_PATH);

        $routes = Misc::jsonToPhpReturnedArray($json);

        file_put_contents(self::ROUTES_PATH, $routes);
    }
}