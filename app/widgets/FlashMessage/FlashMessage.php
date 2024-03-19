<?php

namespace App\Widgets\FlashMessage;

use Funbox\Framework\Session\Session;

class FlashMessage implements FlashMessageInterface
{
    private const FLASH_KEY = 'flash';

    public function __construct(private Session $session)
    {
        $this->session = new Session();
    }

    public function get(string $type): array
    {
        // TODO: Implement get() method.
        return $this->session->read(self::FLASH_KEY);
    }

    public function set(string $type, string $message): void
    {
        // TODO: Implement set() method.
        $this->session->write(self::FLASH_KEY, $message);
    }

    public function hasFlash(string $type): bool
    {
        // TODO: Implement hasFlash() method.
        $this->session->has(self::FLASH_KEY);
    }

    public function clearFlash(): void
    {
        // TODO: Implement clearFlash() method.
    }
}