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
        $this->prepareCacheIfNotExists();

        $routes = require self::ROUTES_PATH;

        $routes[] = [$method, $route, $controller];

        $json = json_encode($routes, JSON_PRETTY_PRINT);

        $routes = Misc::jsonToPhpReturnedArray($json);

        file_put_contents(self::ROUTES_PATH, $routes);
    }

    private function prepareCacheIfNotExists(): void
    {
        if(file_exists(self::ROUTES_PATH)) {
            return;
        }

        if(!touch(self::ROUTES_PATH)) {
            throw new \RuntimeException('Impossible to write ' . self::ROUTES_PATH . ' file.');
        }

        file_put_contents(self::ROUTES_PATH, '<?php return [];');
    }
}