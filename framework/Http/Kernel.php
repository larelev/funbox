<?php

namespace Funbox\Framework\Http;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Kernel
{

    public function handle(Request $request): Response
    {

        $routes  = include APP_PATH . 'routes' . DIRECTORY_SEPARATOR . 'web.php';

        $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) use($routes) {
            foreach ($routes as $route) {
                $routeCollector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPathInfo()
        );

        [$status, [$controller, $method], $vars] = $routeInfo;

        return (new $controller)->$method($vars);
    }

}
