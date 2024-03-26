<?php

$container = \Funbox\Framework\Core\CoreContainer::services();
$container = \Funbox\Plugins\Authentication\Authentication::provide($container);

return $container;
