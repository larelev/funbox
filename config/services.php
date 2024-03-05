<?php

$container = new \League\Container\Container(null, null);
$container->delegate(new \League\Container\ReflectionContainer(true));

$routes = include APP_PATH . 'routes' . DIRECTORY_SEPARATOR . 'web.php';

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(BASE_PATH . '.env');

$appEnv = $_SERVER['APP_ENV'];

$container->add('APP_ENV', new \League\Container\Argument\Literal\StringArgument($appEnv));

$container->add(
    \Funbox\Framework\Routing\RouterInterface::class,
    \Funbox\Framework\Routing\Router::class
);

$container->extend(\Funbox\Framework\Routing\RouterInterface::class)
    ->addMethodCall(
        'setRoutes',
        [new \League\Container\Argument\Literal\ArrayArgument($routes)]
    );

$container->add(\Funbox\Framework\Http\Kernel::class)
    ->addArgument(\Funbox\Framework\Routing\RouterInterface::class)
    ->addArgument($container);

return $container;