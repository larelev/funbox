<?php

namespace Funbox\Framework\Session;

final class Session implements SessionInterface
{
    public function has(string $key): bool
    {
        return session_id() !== null && isset($_SESSION[$key]);
    }

    public function start(string $id = '', array $options = []): false|string
    {
        if (session_id() === '') {
            if($id !== '') {
                session_id($id);
            }

            if(count($options) > 0)  {
                session_start($options);
            } else {
                session_start();
            }
        }

        return session_id();
    }

    public function read(string $key): mixed
    {

        if (session_id() !== '' && isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return null;
    }

    public function write(string $key, mixed $value): bool
    {
        if (session_id() !== null) {
            $_SESSION[$key] = $value;
            return true;
        }

        return false;
    }

    public function delete(string $key = ''): void
    {
        if($key !== '' &&  isset($_SESSION[$key])) {
            unset($_SESSION[$key]);

            return;
        }

        if (session_id() !== '') {
            session_unset();
            session_destroy();
            session_gc();
            session_abort();
        }
    }

}