<?php

namespace Funbox\Plugins;

use Funbox\Framework\Console\Commands\Attributes\Command;
use Funbox\Framework\Console\Commands\CommandInterface;

#[Command(name: "dummy")]
#[Command(desc: "Just a sample command.")]
class Dummy implements CommandInterface
{

    public function execute(array $params = []): int
    {

        echo <<<COWSAY
        ___________________________
        /          This is         \
        |      A dummy command     |
        \                          /
         ---------------------------
             \  ^__^
              \ (oo)\________
                (__)\        )\/\
                    ||----w |
                    ||     ||
        COWSAY.PHP_EOL;

        return 0;
    }

}
