<?php

namespace Funbox\Plugins\FlashMessage;

use Funbox\Plugins\FlashMessage\Enums\FlashType;

interface FlashMessageInterface
{
    public function get(FlashType $type): array;

    public function set(FlashType $type, string $message, ...$params): void;

    public function has(FlashType $type): bool;

    public function getInfo(): array;
    public function getError(): array;
    public function getSuccess(): array;
    public function getWarning(): array;

    public function setInfo(string $message, ...$params): void;
    public function setError(string $message, ...$params): void;
    public function setSuccess(string $message, ...$params): void;
    public function setWarning(string $message, ...$params): void;

    public function hasInfo(): bool;
    public function hasError(): bool;
    public function hasSuccess(): bool;
    public function hasWarning(): bool;

    public function clear(): void;
}
