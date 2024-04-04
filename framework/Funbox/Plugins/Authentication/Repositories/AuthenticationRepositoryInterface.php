<?php

namespace Funbox\Plugins\Authentication\Repositories;

use Funbox\Plugins\Authentication\Components\AuthenticationInterface;

interface AuthenticationRepositoryInterface
{
    public function findByEmail(string $email): ?AuthenticationInterface;
}
