<?php

namespace Funbox\Framework\Console;

use Psr\Container\ContainerInterface;

class Kernel
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function handle(): int
    {
        $this->registerCommands();

        return  0;
    }

    private function registerCommands(): void
    {
        $commandFiles = new \DirectoryIterator(__DIR__ . DIRECTORY_SEPARATOR . 'Commands');
        $namespace = $this->container->get('base-commands-namespace');

        foreach ($commandFiles as $commandFile) {
            if(!$commandFile->isFile()) {
                continue;
            }

            $coomend = $namespace . pathinfo($commandFile, PATHINFO_FILENAME);
        }
    }
}