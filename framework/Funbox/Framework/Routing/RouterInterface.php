<?php

namespace Funbox\Framework\Routing;

use Funbox\Framework\Http\Request;
use Psr\Container\ContainerInterface;

interface RouterInterface
{
    public function dispatch(Request $request, ContainerInterface $container): array;

    public function setRoutes(array $routes): void;
}
