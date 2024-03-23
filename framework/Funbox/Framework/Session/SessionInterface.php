<?php

namespace Funbox\Framework\Session;

interface SessionInterface
{
    public function start(string $id = '', array $options = []): false|string;

    public function has(string $key): bool;

    public function read(string $key): mixed;

    public function write(string $key, mixed $value): bool;

    public function remove(string $key): void;

    public function clear(): void;
}