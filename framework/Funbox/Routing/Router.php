<?php

namespace Funbox\Framework\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Funbox\Framework\Exceptions\HttpException;
use Funbox\Framework\Exceptions\HttpRequestMethodException;
use Funbox\Framework\Http\Request;
use Psr\Container\ContainerInterface;
use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    private array $routes;

    public function dispatch(Request $request, ContainerInterface $container): array
    {
        $routeInfo = $this->extractRouteInfo($request);

        [$handler, $vars] = $routeInfo;

        if(is_array($handler)) {
            [$controllerId, $method] = $handler;
            $controller = $container->get($controllerId);
            $handler = [$controller, $method];
        }

        return [$handler, $vars];
    }

    public function extractRouteInfo(Request $request): array
    {

        $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {
            foreach ($this->routes as $route) {
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
                throw new HttpRequestMethodException("Allowed methods are $allowedMethods.", 405);
            default:
                throw new HttpException('Endpoint not found', 404);

        }

    }

    public function setRoutes(array $routes): void
    {
        $this->routes = $routes;
    }
}
