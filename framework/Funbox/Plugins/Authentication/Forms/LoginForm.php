<?php

namespace Funbox\Plugins\Authentication\Forms;

use Funbox\Plugins\Authentication\Entities\User;
use Funbox\Plugins\Authentication\Repositories\UserMapper;

class EmailForm
{
    private string $email;
    private string $password;
    private array $errors = [];
    private int $errorCount = -1;

    public function __construct(private UserMapper $userMapper)
    {
    }

    public function setFields(string $email, string $password): void
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function save(): User
    {
        $user = User::create($this->email, $this->password);

        $this->userMapper->save($user);

        return $user;
    }

    public function hasValidationErrors(): bool
    {
        if($this->errorCount == -1) {
            $this->errorCount = count($this->getValidationErrors());
        }
        return $this->errorCount > 0;
    }

    public function getValidationErrors(): array
    {
        if(!empty($this->errors)) {
            return $this->errors;
        }

        if(!preg_match('/^\w+$/', $this->email)) {
            $this->errors[] = "Email can only consist of word character without space.";
        }

        if(strlen($this->password) < 8) {
            $this->errors[] = "Password must be at least 8 characters long.";
        }

        return $this->errors;
    }
}