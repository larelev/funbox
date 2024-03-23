<?php

namespace Funbox\Framework\Console;

use Funbox\Framework\Console\Commands\CommandInterface;
use Funbox\Framework\Console\Commands\CommandRunner;
use Funbox\Framework\Console\Exceptions\ConsoleException;
use League\Container\DefinitionContainerInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Kernel
{
    public function __construct(
        private readonly DefinitionContainerInterface $container,
        private readonly CommandRunner $commandRunner
    )
    {
    }

    /**
     * @throws ConsoleException
     */
    public function handle(array $argv, int $argc): int
    {
        $this->registerCommands();

        $status = $this->commandRunner->run($argv, $argc);

        return  $status;
    }

    private function registerCommands(): void
    {
        $commandsLocations = [
            (object)[
                'namespace' => $this->container->get('base-commands-namespace'),
                'directory' => LIB_PATH . 'Commands',
            ],
            (object)[
                'namespace' => $this->container->get('plugins-commands-namespace'),
                'directory' => LIB_PATH . 'Plugins',
            ],
        ];

        foreach ($commandsLocations as $location) {
            $iterator = new RecursiveDirectoryIterator($location->directory);
            $commandFiles = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST);

            foreach ($commandFiles as $commandFile) {
                if(!$commandFile->isFile() || $commandFile->getExtension() !== 'php') {
                    continue;
                }

                $this->registerOneCommand($commandFile, $location->namespace, $location->directory);

            }
        }

    }

    private function registerOneCommand(\SplFileInfo $commandFile, string $namespace, string $directory)
    {
        $l = strlen($directory);

        $baseDomain = $commandFile->getPath() !== '' ? substr($commandFile->getPath(), $l + 1) : '';
        $domain = $baseDomain !== '' ?  $baseDomain . '\\' : '';
        $category = $baseDomain !== '' ? strtolower($baseDomain) . ':' : '';

        $fqCommandClass = str_replace('/', '\\', $namespace . $domain . $commandFile->getBaseName('.' . $commandFile->getExtension()));

        if(!is_subclass_of($fqCommandClass, CommandInterface::class)) {
            return;
        }

        $class = new \ReflectionClass($fqCommandClass);

        $attributesArgs = [];
        $attributes = $class->getAttributes();
        foreach ($attributes as $attribute) {
            $attributesArgs = array_merge($attributesArgs, $attribute->getArguments());
        }

        $commandName = $category . $attributesArgs['name'];
        $containerArgs = $attributesArgs['inject'] ?? [];
        $shortParams = $attributesArgs['shortArgs'] ?? [];
        $longParams = $attributesArgs['longArgs'] ?? [];
        $registeredParams = [$shortParams, $longParams];

        $this->container->addShared($commandName . ':registered-params', $registeredParams);

        $definition = $this->container->addShared($commandName, $fqCommandClass);
        if(count($containerArgs)) {
            $definition->addArguments($containerArgs);
        }

    }
}