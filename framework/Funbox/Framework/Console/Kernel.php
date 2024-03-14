<?php

namespace Funbox\Framework\Console;

use Doctrine\DBAL\Connection;
use Funbox\Framework\Console\Commands\CommandInterface;
use League\Container\DefinitionContainerInterface;

class Kernel
{
    public function __construct(
        private readonly DefinitionContainerInterface $container,
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

            $command = $namespace . pathinfo($commandFile, PATHINFO_FILENAME);

            if(!is_subclass_of($command, CommandInterface::class)) {
                continue;
            }

            $class = new \ReflectionClass($command);

            $commandAttrName = $class->getAttributes()[0];
            $commandAttrContainerArgs = $class->getAttributes()[1];
            $commandName = $commandAttrName->getArguments()['name'];
            $containerArgs = $commandAttrContainerArgs->getArguments()['containerArgs'];

            $this->container->addShared($commandName, $command)
                ->addArguments($containerArgs);

        }
    }
}