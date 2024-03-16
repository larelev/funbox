<?php

use Doctrine\DBAL\Schema\Schema;

class Migration_<Version />
{
    public function __construct(private readonly Schema $schema)
    {
    }

    public function up(): void
    {
        echo __METHOD__ . " executed" . PHP_EOL;
    }

    public function down(): void
    {
        echo __METHOD__ . " executed" . PHP_EOL;
    }
};