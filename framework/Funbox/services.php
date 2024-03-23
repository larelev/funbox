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
    new \League\Container\Argument\Literal\StringArgument('Funbox\\Commands\\'),
);
$container->add('plugins-commands-namespace',
    new \League\Container\Argument\Literal\StringArgument('Funbox\\Plugins\\'),
);

$container->add(
    \Funbox\Framework\Routing\RouterInterface::class,
    \Funbox\Framework\Routing\Router::class,
);

$container->extend(\Funbox\Framework\Routing\RouterInterface::class)
    ->addMethodCall(
        'setRoutes',
        [new \League\Container\Argument\Literal\ArrayArgument($routes)]
    );

$container->add(
    \Funbox\Framework\Middleware\RequestHandlerInterface::class,
    \Funbox\Framework\Middleware\RequestHandler::class
)->addArgument($container);

$container->add(\Funbox\Framework\Http\Kernel::class)
    ->addArguments([
        \Funbox\Framework\Routing\RouterInterface::class,
        $container,
        \Funbox\Framework\Middleware\RequestHandlerInterface::class,
    ]);

$container->add(\Funbox\Framework\Console\Commands\CommandRunner::class)
    ->addArgument($container);

$container->add(\Funbox\Framework\Console\Kernel::class)
    ->addArguments([$container, \Funbox\Framework\Console\Commands\CommandRunner::class]);

$container->addShared(
    \Funbox\Framework\Session\SessionInterface::class,
    \Funbox\Framework\Session\Session::class,
);

$container->addShared(
    \Funbox\Plugins\FlashMessage\FlashMessageInterface::class,
    \Funbox\Plugins\FlashMessage\FlashMessage::class,
);

$container->add('template-renderer-factory', \Funbox\Framework\Template\TwigFactory::class)
    ->addArguments([
        \Funbox\Plugins\FlashMessage\FlashMessageInterface::class,
        new \League\Container\Argument\Literal\StringArgument($viewsPath),
    ]);

$container->addShared('twig', function () use ($container) {
    return $container->get('template-renderer-factory')->create();
});

$container->add(\Funbox\Framework\Dbal\ConnectionFactory::class)
    ->addArgument(
        new \League\Container\Argument\Literal\StringArgument(DATABASE_URL)
    );

$container->addShared(\Doctrine\DBAL\Connection::class, function () use ($container): \Doctrine\DBAL\Connection {
    return $container->get(\Funbox\Framework\Dbal\ConnectionFactory::class)->create();
});

$container->add(\Funbox\Framework\Middleware\RouterDispatcher::class)
    ->addArguments([
        \Funbox\Framework\Routing\RouterInterface::class,
        $container,
    ]);

return $container;
