<?php

namespace Funbox\Framework\Routing;

use Funbox\Framework\Caching\Cache;

class Route
{
    private static ?RoutesAggregator $aggregator = null;

    private static function getAggregator(): RoutesAggregator
    {
        if(self::$aggregator === null) {
            self::$aggregator = new RoutesAggregator;
        }
        return self::$aggregator;
    }

    public static function get(string $route, array|callable $controller)
    {
        static::getAggregator()->aggregate('GET', $route, $controller);
    }

    public static function post(string $route, array|callable $controller)
    {
        static::getAggregator()->aggregate('POST', $route, $controller);
    }

}