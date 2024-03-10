<?php

namespace Funbox\Framework\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class ConnectionFactory
{
    public function __construct(private string $databaseURL)
    {
    }

    public function create(): Connection
    {
        return DriverManager::getConnection(['url' => $this->databaseURL]);
    }
}