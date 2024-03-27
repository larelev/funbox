<?php

$container = \Funbox\Framework\Core\CoreContainer::provide();
$container = \Funbox\Plugins\Authentication\Container::provide($container);
$container = \Funbox\Plugins\FlashMessage\Container::provide($container);
$container->add('template-renderer-factory', \App\Factories\TwigFactory::class);

return $container;
