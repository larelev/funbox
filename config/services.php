<?php

$container = \Funbox\Framework\Core\CoreContainer::provide();
$container = \Funbox\Plugins\Authentication\Container::provide($container);
$container = \Funbox\Plugins\FlashMessage\Container::provide($container);

return $container;
