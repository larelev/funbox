<?php

namespace Funbox\Framework\Session;

interface SessionInterface
{
    public function has(string $key): bool;

    public function read(string $key): mixed;

    public function write(string $key, mixed $value): void;

    public function delete(): void;
}