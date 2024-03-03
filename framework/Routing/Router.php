<?php

namespace Funbox\Framework\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Funbox\Framework\Http\Exceptions\HttpException;
use Funbox\Framework\Http\Exceptions\HttpRequestMethodException;
use Funbox\Framework\Http\Request;
use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{

    public function dispatch(Request $request): array
    {
        $routeInfo = $this->extractRouteInfo($request);

        [$handler, $vars] = $routeInfo;

        [$controller, $method] = $handler;

        return [[new $controller, $method], $vars];
    }

    public function extractRouteInfo(Request $request)
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

        switch ($routeInfo[0]) {
            case  Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = implode(', ', $routeInfo[1]);
                throw new HttpRequestMethodException("Allowed methods are $allowedMethods.", 400);
            default:
                throw new HttpException('Endpoint not found', 404);

        }

        return $routeInfo;
    }
}
