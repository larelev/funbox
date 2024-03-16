<?php

use Doctrine\DBAL\Schema\AbstractSchemaManager;

class Migration_20240316162823267254
{
    public function __construct(private readonly AbstractSchemaManager $schema)
    {
    }

    public function up(): void
    {
        echo __METHOD__ . " executed!" . PHP_EOL;
    }

    public function down(): void
    {
        echo __METHOD__ . " executed!" . PHP_EOL;
    }
};