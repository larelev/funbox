<?php

$container = new \League\Container\Container();
$container->delegate(new \League\Container\ReflectionContainer(false));

$routes = include APP_PATH . 'routes' . DIRECTORY_SEPARATOR . 'web.php';
$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$viewsPath = APP_PATH . 'views' . DIRECTORY_SEPARATOR;

$dotenv->load(BASE_PATH . '.env');

$appEnv = $_SERVER['APP_ENV'];

$container->add('APP_ENV', new \League\Container\Argument\Literal\StringArgument($appEnv));
$container->add('base-commands-namespace',
    new \League\Container\Argument\Literal\StringArgument('Funbox\\Commands\\')
);

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

$container->add(\Funbox\Framework\Console\Commands\CommandRunner::class)
    ->addArgument($container);

$container->add(\Funbox\Framework\Console\Kernel::class)
    ->addArguments([$container, \Funbox\Framework\Console\Commands\CommandRunner::class]);

$container->addShared('filesystem-loader', \Twig\Loader\FilesystemLoader::class)
    ->addArgument(new \League\Container\Argument\Literal\StringArgument(APP_PATH . 'views'));

$container->addShared('twig', Twig\Environment::class)
    ->addArgument('filesystem-loader');

$container->add(\Funbox\Framework\Dbal\ConnectionFactory::class)
    ->addArgument(
        new \League\Container\Argument\Literal\StringArgument(DATABASE_URL)
    );

$container->addShared(\Doctrine\DBAL\Connection::class, function () use ($container): \Doctrine\DBAL\Connection {
    return $container->get(\Funbox\Framework\Dbal\ConnectionFactory::class)->create();
});

return $container;
