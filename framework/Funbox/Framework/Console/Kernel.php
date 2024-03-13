<?php

namespace Funbox\Framework\Console;

use Funbox\Framework\Console\Commands\CommandInterface;
use Psr\Container\ContainerInterface;

class Kernel
{
    public function __construct(
        private readonly ContainerInterface $container,
        private readonly CommandRunner $commandRunner
    )
    {
    }

    public function handle(array $argv, int $argc): int
    {
        $this->registerCommands();

        $status = $this->commandRunner->run($argv, $argc);

        return  $status;
    }

    private function registerCommands(): void
    {
        $commandFiles = new \DirectoryIterator(LIB_PATH . 'Commands');
        $namespace = $this->container->get('base-commands-namespace');

        foreach ($commandFiles as $commandFile) {
            if(!$commandFile->isFile()) {
                continue;
            }

            $coomend = $namespace . pathinfo($commandFile, PATHINFO_FILENAME);

            if(!is_subclass_of($coomend, CommandInterface::class)) {
                continue;
            }

            $class = new \ReflectionClass($coomend);
            $commandAttr = $class->getAttributes()[0];
            $commandName = $commandAttr->getArguments()['name'];

            $this->container->add($commandName, $coomend);
        }
    }
}