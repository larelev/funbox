<?php

namespace Funbox\Plugins\Authentication;

use Funbox\Framework\Container\PluginContainerInterface;
use League\Container\DefinitionContainerInterface;

class Container implements PluginContainerInterface
{

    public static function provide(DefinitionContainerInterface $container): DefinitionContainerInterface
    {
        $container->add(\Funbox\Plugins\Authentication\Components\Authenticator::class)
            ->addArguments([
                \Funbox\Plugins\Authentication\Repositories\UserRepository::class,
                \Funbox\Framework\Session\SessionInterface::class,
            ]);

        return $container;
    }
}
