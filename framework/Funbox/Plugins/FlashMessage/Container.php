<?php

namespace Funbox\Plugins\FlashMessage;

use Funbox\Framework\Container\PluginContainerInterface;
use League\Container\DefinitionContainerInterface;

class Container implements PluginContainerInterface
{
    public static function provide(DefinitionContainerInterface $container): DefinitionContainerInterface
    {
        $container->addShared(
            \Funbox\Plugins\FlashMessage\FlashMessageInterface::class,
            \Funbox\Plugins\FlashMessage\FlashMessage::class,
        );

        return $container;
    }
}