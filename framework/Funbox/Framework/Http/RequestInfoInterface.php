<?php

namespace Funbox\Framework\Http;

interface RequestInfoInterface
{
    public function getGetParams(string $param = ''): array | string;
    public function getPostParams(string $param = ''): array | string;
    public function getCookies($name = ''): array | string;
    public function getFiles(): array;
    public function getServer(): array;
    public function getPathInfo(): string;
    public function getMethod(): string;
}
