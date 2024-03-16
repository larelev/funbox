<?php

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

class Migration20240316123841736623
{
    public function __construct(private readonly Schema $schema)
    {
    }

    public function up(): void
    {
        $table = $this->schema->createTable('posts');
        $table->addColumn('id', Types::INTEGER, ['autoincrement' => true, 'unsigned' => true]);
        $table->addColumn('title', Types::STRING, ['length' => 255]);
        $table->addColumn('body', Types::TEXT);
        $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, ['default' => 'CURRENT_TIMESTAMP']);
        $table->setPrimaryKey(['id']);
        echo __METHOD__ . " executed" . PHP_EOL;
    }

    public function down(): void
    {
        echo __METHOD__ . " executed" . PHP_EOL;
    }
};