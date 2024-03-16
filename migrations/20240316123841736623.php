<?php

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Table;

class Migration_20240316123841736623
{
    public function __construct(private readonly AbstractSchemaManager $schema)
    {
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function up(): void
    {
        $table = new Table('posts');
        $table->addColumn('id', Types::INTEGER, ['autoincrement' => true, 'unsigned' => true]);
        $table->addColumn('title', Types::STRING, ['length' => 255]);
        $table->addColumn('body', Types::TEXT);
        $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, ['default' => 'CURRENT_TIMESTAMP']);
        $table->setPrimaryKey(['id']);

        $this->schema->createTable($table);

        echo __METHOD__ . " executed!" . PHP_EOL;
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function down(): void
    {
        $this->schema->dropTable('posts');

        echo __METHOD__ . " executed!" . PHP_EOL;
    }
};