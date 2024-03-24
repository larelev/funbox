<?php

namespace Funbox\Plugins\Registration\Forms;

class RegistrationForm
{
    private string $login;
    private string $password;

    public function setFields(string $login, string $password): void
    {
        $this->login = $login;
        $this->password = $password;

    }
}