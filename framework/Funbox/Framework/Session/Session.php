<?php

namespace Funbox\Framework\Session;

use Funbox\Framework\Logger\Logger;

final class Session implements SessionInterface
{
    public const CSRF_TOKEN = 'CSRF-TOKEN';
    public const SESSION_ID = 'SESSION-ID';

    public function getId(): false|string
    {
        return session_id();
    }

    public function getCookie(): false|string
    {
        $name = session_name();
        return !isset($_COOKIE[$name]) ? false : $_COOKIE[$name];
    }
    public function isActive(): bool
    {
        return !empty(session_id());
    }

    public function has(string $key): bool
    {
        return session_status() == PHP_SESSION_ACTIVE && isset($_SESSION[$key]);
    }

    public function start(string $id = '', array $options = []): false|string
    {
        if (session_status() == PHP_SESSION_NONE) {
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
        if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return null;
    }

    public function write(string $key, mixed $value): bool
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            $_SESSION[$key] = $value;
            return true;
        }

        return false;
    }

    public function remove(string $key): void
    {
        if(session_status() == PHP_SESSION_ACTIVE && $key !== '' &&  isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public function clear(): void
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_gc();
            session_unset();
            session_destroy();
            session_abort();
        }
    }
}