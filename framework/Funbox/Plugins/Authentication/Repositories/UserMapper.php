<?php

namespace Funbox\Plugins\Authentication\Repositories;

use Doctrine\DBAL\Connection;
use Funbox\Framework\Dbal\DataMapper;
use Funbox\Framework\Dbal\Entity;
use Funbox\Plugins\Authentication\Entities\User;

class UserMapper extends DataMapper
{

    public function insert(User|Entity &$entity): void
    {
        $stmt = $this->connection->prepare("
            INSERT INTO users (email, password, created_at)
            VALUES (:email, :password, :created_at)
        ");

        $stmt->bindValue(":email", $entity->getEmail());
        $stmt->bindValue(":password", $entity->getPassword());
        $stmt->bindValue(":created_at", $entity->getCreatedAt()->format('Y-m-d H:i:s'));

        $stmt->executeStatement();
    }
}