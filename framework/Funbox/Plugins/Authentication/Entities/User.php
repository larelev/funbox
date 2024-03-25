<?php

namespace Funbox\Plugins\Authentication\Entities;

class User
{
    public function __construct(
        private readonly string             $email,
        private readonly string             $password,
        private readonly \DateTimeImmutable $createdAt,
        private ?int                        $id = null,
    )
    {
    }

    public function getEmail(): string
    {
        return $this->email;
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

    public static function create(string $email, string $password): self
    {
        return new self(
            email: $email,
            password: password_hash($password, PASSWORD_DEFAULT),
            createdAt:new \DateTimeImmutable(),
        );
    }
}