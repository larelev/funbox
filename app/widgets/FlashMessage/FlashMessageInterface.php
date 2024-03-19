<?php

namespace App\Widgets\FlashMessage;

interface FlashMessageInterface
{
    public function get(string $type): array;

    public function set(string $type, string $message): void;

    public function hasFlash(string $type): bool;

    public function clearFlash(): void;
}