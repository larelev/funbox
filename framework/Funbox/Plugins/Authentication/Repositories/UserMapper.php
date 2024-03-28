<?php

namespace Funbox\Plugins\Authentication\Repositories;

use Doctrine\DBAL\Connection;
use Funbox\Plugins\Authentication\Entities\User;

class UserMapper
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function save(User $user): void
    {
        $stmt = $this->connection->prepare("
            INSERT INTO users (email, password, created_at)
            VALUES (:email, :password, :created_at)
        ");

        $stmt->bindValue(":email", $user->getEmail());
        $stmt->bindValue(":password", $user->getPassword());
        $stmt->bindValue(":created_at", $user->getCreatedAt()->format('Y-m-d H:i:s'));

        $stmt->executeStatement();

        $id = $this->connection->lastInsertId();

        $user->setId($id);

    }
}