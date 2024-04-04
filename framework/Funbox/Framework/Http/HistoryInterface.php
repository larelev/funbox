<?php

namespace Funbox\Framework\Http;

interface HistoryInterface
{
    public function getLastRequest(): ?RequestInfo;

    public function getLastGetRequest(): ?RequestInfo;

    public function get(): array;

    public function set(RequestInfo $info): void;

    public function has(): bool;

    public function clear(): void;
}
