<?php

namespace Funbox\Commands;

use Funbox\Framework\Console\Commands\Attributes\Command;
use Funbox\Framework\Console\Commands\CommandInterface;

#[Command(name: "help")]
class Help implements CommandInterface
{

    public function execute(array $params = []): int
    {

        echo <<<COWSAY
        ___________________________
        /       It looks like       \
        | you don't know what to do |
        \ Use php bin/console help  /
         ---------------------------
             \  ^__^
              \ (oo)\________
                (__)\        )\/\
                    ||----w |
                    ||     ||
        COWSAY . PHP_EOL;

        return 0;
    }

}
