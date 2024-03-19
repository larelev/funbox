<?php

namespace Funbox\Framework\Session;

final class Session implements SessionInterface
{
    public function __construct()
    {
        if (session_id() === null) {
            session_start();
        }
    }

    public function read(string $key): mixed
    {
        if (session_id() !== null && isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    public function write(string $key, mixed $value): void
    {
        if (session_id() !== null) {
            $_SESSION[$key] = $value;
        }
    }

    public function delete(): void
    {
        session_unset();
        session_destroy();
        session_gc();
        session_abort();
    }

    public function has(string $key): bool
    {
        return session_id() !== null && isset($_SESSION[$key]);
    }
}