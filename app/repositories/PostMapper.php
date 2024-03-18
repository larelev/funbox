<?php

namespace App\Repositories;

use App\Entities\Post;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class PostMapper
{

    public function __construct(private readonly Connection $connection)
    {
    }


    /**
     * @throws Exception
     */
    public function save(Post $post): void
    {
        $stmt = $this->connection->prepare("
        INSERT INTO posts (title, body, created_at)
        VALUES (:title, :body, :created_at)
        ");

        $stmt->bindValue(':title', $post->title);
        $stmt->bindValue(':body', $post->body);
        $stmt->bindValue(':created_at', $post->createdAt->format('Y-m-d H:i:s'));

        $stmt->executeStatement();

        $id = $this->connection->lastInsertId();

        $post->setId($id);
    }
}