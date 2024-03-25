<?php

namespace Funbox\Plugins\Registration\Commands;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;
use Funbox\Framework\Console\Commands\Attributes\Command;
use Funbox\Framework\Console\Commands\Attributes\CommandArgs;
use Funbox\Framework\Console\Commands\Attributes\CommandConstruct;
use Funbox\Framework\Console\Commands\CommandInterface;
use Funbox\Framework\Console\Exceptions\ConsoleException;

#[Command(name: "migration")]
#[Command(desc: "Adds or removes the user registration table from the database.")]
#[CommandArgs(short: ['u', 'd'])]
#[CommandArgs(long: ['up', 'down'])]
#[CommandConstruct(inject: [Connection::class])]
class UserMigration implements CommandInterface
{

    public function __construct(
        public Connection $connection
    )
    {
    }

    public function execute(array $params = []): int
    {
        try
        {
            $doUp =  array_key_exists('u', $params) || array_key_exists('up', $params);
            $doDown =  array_key_exists('d', $params) || array_key_exists('down', $params);
            $doError = array_key_exists('u', $params) && array_key_exists('up', $params);
            $doError = $doError || (array_key_exists('d', $params) && array_key_exists('down', $params));
            $doError = $doError || ($doUp && $doDown);
            $doNothing = !$doUp && !$doDown;

            if($doNothing) {
                throw new ConsoleException('Missing arguments.');
            }

            if($doError) {
                throw new \InvalidArgumentException('Invalid arguments.');
            }

            $this->connection->beginTransaction();

            if($doUp) {
                $version = !isset($params['u']) ? ($params['up'] ?? null) : $params['u'];
            }
            else if($doDown) {
                $version = !isset($params['d']) ? ($params['down'] ?? null) : $params['d'];
            }

            $schemaMan = $this->connection->createSchemaManager();
            $schema = new Schema();

            if($doUp) {
                $this->doUp($schemaMan);
            } else if($doDown) {
                $this->doDown($schemaMan);
            }
            // Execute the SQL query
            $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());

            foreach ($sqlArray as $sql) {
                $this->connection->executeQuery($sql);
            }

            $this->connection->commit();

            return 0;
        } catch (Exception $exception) {
            $this->connection->rollBack();
            throw $exception;
        } catch (\Throwable $throwable) {
            throw $throwable;
        }
    }

    private function doUp(AbstractSchemaManager $schema): void
    {
        if($schema->tableExists('users')) {
            return;
        }
        $table = new Table('users');
        $table->addColumn('id', Types::INTEGER, ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('login', Types::STRING,['length' => 255]);
        $table->addColumn('password', Types::STRING,['length' => 60]);
        $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, ['default' => 'CURRENT_TIMESTAMP']);
        $table->setPrimaryKey(['id']);

        $schema->createTable($table);

        echo 'Users table has been created.' . PHP_EOL;
    }

    private function doDown(AbstractSchemaManager $schema): void
    {
        if(!$schema->tableExists('users')) {
            echo 'Nothing to drop.' . PHP_EOL;
            return;
        }
        $schema->dropTable('users');

        echo 'Users table has been dropped.' . PHP_EOL;
    }

}
