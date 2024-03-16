<?php

namespace Funbox\Commands\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Funbox\Framework\Console\Commands\Attributes\CommandDeclaration;
use Funbox\Framework\Console\Commands\CommandInterface;

#[CommandDeclaration(name: "migrations:migrate")]
#[CommandDeclaration(containerArgs: [Connection::class])]
#[CommandDeclaration(shortParams: ['u', 'd'])]
#[CommandDeclaration(longParams: ['up', 'down'])]
class MigrationsMigrate implements CommandInterface
{


    public function __construct(
        private Connection $connection,
    )
    {
    }

    public function execute(array $params = []): int
    {
        try
        {
            $this->connection->beginTransaction();

            // Create a migrations table SQL if table not already in existence
            $this->createMigrationsTable();

            // Get $appliedMigrations which are already in the database.migrations table
            $appliedMigrations = $this->getAppliedMigrations();

            // Get the $migrationFiles from the migrations folder
            $migrationsFiles = $this->getMigrationsFiles();

            // Get the migrations to apply. i.e. they are in $migrationFiles but not in $appliedMigrations
            $migrationsToApply = array_diff($migrationsFiles, $appliedMigrations);

            $schema = new Schema();

            // Create SQL for any migrations which have not been run ..i.e. which are not in the database
            foreach ($migrationsToApply as $migrationFile) {
                 require BASE_PATH . MIGRATIONS_PATH . $migrationFile;

                 $version = pathinfo($migrationFile, PATHINFO_FILENAME);
                 $className = 'Migration_' . $version;

                 $migrationObject = new $className($schema);
                 $migrationObject->up();

                // Add migration to database
                $this->insertMigration($migrationFile);

            }

            // Execute the SQL query
            $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());

            foreach ($sqlArray as $sql) {
                $this->connection->executeQuery($sql);
            }

            $this->connection->commit();

            return 0;

        } catch (\Throwable $throwable) {
            $this->connection->rollBack();
            throw $throwable;
        }

    }

    private function getMigrationsFiles(): array
    {
        $files = scandir(BASE_PATH . MIGRATIONS_PATH);

        $result = array_filter($files, function ($file) {
            $re = '/([0-9]{20})\.php/';
            preg_match($re, $file, $matches, PREG_OFFSET_CAPTURE, 0);
            return  count($matches) > 0;
        });

        return  $result;
    }

    private function getAppliedMigrations(): array
    {
        $sql = "SELECT migration FROM migrations;";
        return $this->connection->executeQuery($sql)->fetchFirstColumn();
    }

    private function createMigrationsTable(): void
    {
        $schemaManager = $this->connection->createSchemaManager();

        if($schemaManager->tableExists('migrations')) {
            return;
        }

        $schema = new Schema();
        $table = $schema->createTable('migrations');
        $table->addColumn('id', Types::INTEGER, ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('migration', Types::STRING);
        $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, ['default'=>'CURRENT_TIMESTAMP']);
        $table->setPrimaryKey(['id']);

        $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());

        $this->connection->executeQuery($sqlArray[0]);

        echo 'Migrations table has been created.' . PHP_EOL;

    }

    private function insertMigration(string $migration): void
    {
        $sql = "INSERT INTO migrations (migration) VALUES (?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $migration);

        $stmt->executeStatement();
    }
}
