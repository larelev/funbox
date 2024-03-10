<?php

namespace Funbox\Commands;

use Ephect\Framework\Commands\Attributes\CommandDeclaration;
use Funbox\Framework\Console\Commands\CommandInterface;

#[CommandDeclaration(verb: "build")]
class MigrateDatabase implements CommandInterface
{
    public string $name = 'databse:migrations:migrate';
    public function execute(array $params = []): int
    {
        // TODO: Implement execute() method.
        echo "Executing " . __CLASS__ . " command" . PHP_EOL;

        return 0;
    }
}