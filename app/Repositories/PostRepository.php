<?php

namespace App\Repositories;

use App\Entities\Post;
use App\Repositories\Exceptions\PostNotFoundException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class PostRepository
{

    public function __construct(private Connection $connection)
    {
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function findById(int $id): ?Post
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->select('id', 'title', 'body', 'created_at')
            ->from('posts')
            ->where('id = :id')
            ->setParameter('id', $id);

        $result = $queryBuilder->executeQuery();

        $row = $result->fetchAllAssociative();

        if (!isset($row[0])) {
            return null;
        }

        $obj = (object) $row[0];

        return new Post(
            id: $obj->id,
            title: $obj->title,
            body: $obj->body,
            createdAt: new \DateTimeImmutable($obj->createdAt)
        );

    }

    public function findOrFail(int $id): Post
    {
        $post = $this->findById($id);

        if (!$post) {
            throw new PostNotFoundException($id);
        }

        return $post;
    }
}
