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

//            $command = $namespace . (
//                $commandFile->getPath() !== '' ?
//                    str_replace(
//                        substr($commandFile->getPath(), $l + 1),
//                        DIRECTORY_SEPARATOR,
//                        '\\' )
//                    . '\\' : ''
//                ) . $commandFile->getBaseName('.' . $commandFile->getExtension());
//            echo $command . PHP_EOL;

            $baseDomain = $commandFile->getPath() !== '' ? substr($commandFile->getPath(), $l + 1) : '';
            $domain = $baseDomain !== '' ?  $baseDomain . '\\' : '';
            $category = $baseDomain !== '' ? strtolower($baseDomain) . ':' : '';

            $command = $namespace . $domain . $commandFile->getBaseName('.' . $commandFile->getExtension());

            if(!is_subclass_of($command, CommandInterface::class)) {
                continue;
            }

            $class = new \ReflectionClass($command);

            $attributeList = [];
            $attributes = $class->getAttributes();
            foreach ($attributes as $attribute) {
                $attributeList = array_merge($attributeList, $attribute->getArguments());
            }

            $commandName = $category . $attributeList['name'];
            $containerArgs = isset($attributeList['containerArgs']) ? $attributeList['containerArgs'] : [];
            $shortParams = isset($attributeList['shortParams']) ? $attributeList['shortParams'] : [];
            $longParams = isset($attributeList['longParams']) ? $attributeList['longParams'] : [];
            $registeredParams = [$shortParams, $longParams];

            $this->container->addShared($commandName . ':registered-params', $registeredParams);

            $definition = $this->container->addShared($commandName, $command);
            if(count($containerArgs)) {
                $definition->addArguments($containerArgs);
            }

        }
    }
}