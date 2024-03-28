<?php

namespace Funbox\Plugins\Authentication\Repositories;

use Doctrine\DBAL\Connection;
use Funbox\Plugins\Authentication\Components\AuthenticationInterface;
use Funbox\Plugins\Authentication\Entities\User;

class UserRepository implements AuthenticationRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }

    public function findByEmail(string $email): ?AuthenticationInterface
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->select('id', 'email', 'password', 'created_at')
            ->from('users')
            ->where('email = :email')
            ->setParameter('email', $email);

        $result = $queryBuilder->executeQuery();

        $row = $result->fetchAllAssociative();

        if(!isset($row[0])) {
            return null;
        }

        $obj = (object)$row[0];

        $user = new User(
            id: $obj->id,
            email: $obj->email,
            password: $obj->password,
            createdAt: new \DateTimeImmutable($obj->created_at)
        );

        return $user;
    }
}