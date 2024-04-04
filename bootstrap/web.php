<?php

use Funbox\Framework\Event\Service\EventServiceProvider;

$container = require SERVICES_PATH;

$providers = [EventServiceProvider::class];

foreach ($providers as $providerClass) {
    $provider = $container->get($providerClass);
    $provider->register();
}

return $container;
