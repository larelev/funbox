<?php

namespace Funbox\Framework\Console;

use Funbox\Framework\Exceptions\ConsoleException;
use Psr\Container\ContainerInterface;

class CommandRunner
{

    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function run(array $argv, int $argc): int
    {
        $commandName = $argv[1] ?? false;

        if(!$commandName) {
            throw new ConsoleException('Missing command name!');
        }

        $command = $this->container->get($commandName);

        $args =  array_slice($argv, 2);

        $options = $this->parseOptions($args, $argc - 2);

        $status = $command->execute($options);

        return $status;
    }

    private function parseOptions(array $args, int $count): array
    {
        $result = [];

        for ($i = 0; $i < $count; $i++) {
            $current = $args[$i];
            if(str_starts_with($current, '--')) {
                [$key, $value] = explode('=', substr($current, 2));
                $result[$key] = $value ?? true;
            }
            else
            if(str_starts_with($current, '-')) {
                $next = $i + 1 < $count ? $args[$i + 1] : '';

                $key = substr($current, 1);
                $value = str_starts_with($next, '-') ? true : $next;

                $result[$key] = $value;
            }
        }

        return $result;
    }
}