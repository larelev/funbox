<?php

namespace Funbox\Framework\Console;

use Funbox\Framework\Console\Commands\CommandInterface;
use Funbox\Framework\Console\Commands\CommandRunner;
use Funbox\Framework\Exceptions\ConsoleException;
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
        $dir = LIB_PATH . 'Commands';
        $l = strlen($dir);
        $dir_iterator = new RecursiveDirectoryIterator($dir);
        $commandFiles = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::CHILD_FIRST);

        $namespace = $this->container->get('base-commands-namespace');

        foreach ($commandFiles as $commandFile) {
            if(!$commandFile->isFile()) {
                continue;
            }

//            $fqCommandClass = $namespace . (
//                $commandFile->getPath() !== '' ?
//                    str_replace(
//                        substr($commandFile->getPath(), $l + 1),
//                        DIRECTORY_SEPARATOR,
//                        '\\' )
//                    . '\\' : ''
//                ) . $commandFile->getBaseName('.' . $commandFile->getExtension());
//            echo $fqCommandClass . PHP_EOL;

            $baseDomain = $commandFile->getPath() !== '' ? substr($commandFile->getPath(), $l + 1) : '';
            $domain = $baseDomain !== '' ?  $baseDomain . '\\' : '';
            $category = $baseDomain !== '' ? strtolower($baseDomain) . ':' : '';

            $fqCommandClass = $namespace . $domain . $commandFile->getBaseName('.' . $commandFile->getExtension());

            if(!is_subclass_of($fqCommandClass, CommandInterface::class)) {
                continue;
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
}