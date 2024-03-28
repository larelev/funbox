<?php

namespace Funbox\Framework\Routing;

use Funbox\Framework\Caching\Cache;
use Funbox\Framework\Utils\Text;

class RoutesAggregator
{
    public const ROUTES_JSON_PATH = Cache::CACHE_PATH . 'routes.json';
    public const ROUTES_PATH = Cache::CACHE_PATH . 'routes.php';

    function aggregate(string $method, string $route, array|callable $controller, ?array $middlewares = null): void
    {

        $this->prepareCacheIfNotExists();

        $json = file_get_contents(self::ROUTES_JSON_PATH);

        $routes = json_decode($json, JSON_OBJECT_AS_ARRAY);

        if($middlewares === null) {
            $routes[] = [$method, $route, $controller];
        } else {
            $routes[] = [$method, $route, $controller, $middlewares];

        }

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

        $routes = Text::jsonToPhpReturnedArray($json);

        file_put_contents(self::ROUTES_PATH, $routes);
    }
}