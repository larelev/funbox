<?php

namespace App\Widgets\FlashMessage;

use App\Widgets\FlashMessage\Enums\FlashType;

interface FlashMessageInterface
{
    public function get(FlashType $type): array;

    public function set(FlashType $type, string $message): void;

    public function hasFlash(FlashType $type): bool;

    public function clearFlash(): void;
}