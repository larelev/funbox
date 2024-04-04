<?php

namespace App\Repositories;

use App\Entities\Post;
use Funbox\Framework\Dbal\DataMapper;
use Funbox\Framework\Dbal\Entity;

class PostMapper extends DataMapper
{

    public function insert(Post | Entity &$entity): void
    {
        $stmt = $this->connection->prepare("
        INSERT INTO posts (title, body, created_at)
        VALUES (:title, :body, :created_at)
        ");

        $stmt->bindValue(':title', $entity->title);
        $stmt->bindValue(':body', $entity->body);
        $stmt->bindValue(':created_at', $entity->createdAt->format('Y-m-d H:i:s'));

        $stmt->executeStatement();

    }
}
