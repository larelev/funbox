<?php

namespace Funbox\Plugins\Authentication\Components;

interface AuthenticatorInterface
{
    public function authenticate(string $email, string $password): bool;
    public function login(AuthenticationInterface $user): void;
    public function logout(): void;
    public function getUser(): AuthenticationInterface;

}