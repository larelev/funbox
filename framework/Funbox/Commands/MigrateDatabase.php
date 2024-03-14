<?php

namespace Funbox\Commands;

use Doctrine\DBAL\Connection;
use \Doctrine\DBAL\Driver\PDO\Connection as PDOConnection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Funbox\Framework\Console\Commands\Attributes\CommandDeclaration;
use Funbox\Framework\Console\Commands\CommandInterface;

#[CommandDeclaration(name: "database:migrations:migrate")]
#[CommandDeclaration(containerArgs: [Connection::class])]
//#[CommandDeclaration(containerArgs: [Connection::class,  new PDOConnection(new \PDO(DATABASE_URL))])]
class MigrateDatabase implements CommandInterface
{


    public function __construct(
        private Connection $abstractConnection,
    )
    {
    }

    public function execute(array $params = []): int
    {

        // Create a migrations table SQL if table not already in existence
        $this->createMigrationsTable();

        // Get $appliedMigrations which are already in the database.migrations table

        // Get the $migrationFiles from the migrations folder

        // Get the migrations to apply. i.e. they are in $migrationFiles but not in $appliedMigrations

        // Create SQL for any migrations which have not been run ..i.e. which are not in the database

        // Add migration to database

        // Execute the SQL query

        return 0;
    }

    private function createMigrationsTable(): void
    {
        $schemaManager = $this->abstractConnection->createSchemaManager();

        if(!$schemaManager->tableExists('migrations')) {
            $schema = new Schema();
            $table = $schema->createTable('migrations');
            $table->addColumn('id', Types::INTEGER, ['unsigned' => true, 'autoincrement' => true]);
            $table->addColumn('migration', Types::STRING);
            $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, ['default'=>'CURRENT_TIMESTAMP']);
            $table->setPrimaryKey(['id']);

            $sqlArray = $schema->toSql($this->abstractConnection->getDatabasePlatform());

            $this->abstractConnection->executeQuery($sqlArray[0]);

            echo 'migrations table created' . PHP_EOL;
        }

    }
}