<?php

namespace Funbox\Framework\Core;

use Funbox\Framework\Session\SessionInterface;
use Funbox\Plugins\Authentication\Components\AuthenticatorInterface;
use Funbox\Plugins\Authentication\Repositories\AuthenticationRepositoryInterface;
use League\Container\DefinitionContainerInterface;

class CoreContainer
{
    public static function services(): DefinitionContainerInterface
    {
        $container = new \League\Container\Container();
        $container->delegate(new \League\Container\ReflectionContainer(false));

        $routes = include \Funbox\Framework\Routing\RoutesAggregator::ROUTES_PATH;
        $dotenv = new \Symfony\Component\Dotenv\Dotenv();

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

    }
}