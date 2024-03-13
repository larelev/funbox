<?php

namespace Funbox\Framework\Console;

use Funbox\Framework\Core\AbstractApplication;

class Application extends AbstractApplication
{

    public static function create(): static
    {
        $clasName = get_class();
        return new $clasName;
    }

    public function run(array $argv, int $argc): int
    {
        $container = require_once BASE_PATH . 'config' . DIRECTORY_SEPARATOR . 'services.php';

        $kernel = $container->get(Kernel::class);

        return $kernel->handle($argv, $argc);
    }
}