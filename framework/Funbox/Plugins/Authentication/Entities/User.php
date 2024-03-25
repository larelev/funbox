<?php

namespace Funbox\Plugins\Authentication\Entities;

class User
{
    public function __construct(
        private readonly string             $login,
        private readonly string             $password,
        private readonly \DateTimeImmutable $createdAt,
        private ?int                        $id = null,
    )
    {
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public static function create(string $login, string $password): self
    {
        return new self(
            login: $login,
            password: password_hash($password, PASSWORD_DEFAULT),
            createdAt:new \DateTimeImmutable(),
        );
    }
}