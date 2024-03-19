<?php

namespace App\Widgets\FlashMessage;

use Funbox\Framework\Session\Session;
use App\Widgets\FlashMessage\Enums\FlashType;


class FlashMessage implements FlashMessageInterface
{
    private const FLASH_KEY = 'flash';
    private Session $session;

    public function __construct()
    {
        $this->session = new Session();
        $this->session->start();
    }

    public function get(FlashType $type): array
    {
        $flashes = $this->session->read(self::FLASH_KEY) ?? [];
        if(isset($flashes[$type->name])) {
            $messages = $flashes[$type->name];
            unset($flashes[$type->name]);
            $this->session->write(self::FLASH_KEY, $flashes);

            return $messages;
        }

        return [];
    }

    public function set(FlashType $type, string $message): void
    {
        $flashes = $this->session->read(self::FLASH_KEY) ?? [];
        $flashes[$type->name][] = $message;
        $this->session->write(self::FLASH_KEY, $flashes);
    }

    public function hasFlash(FlashType $type): bool
    {
        if($this->session->has(self::FLASH_KEY)) {
            $flashes = $this->session->read(self::FLASH_KEY);
            return isset($flashes[$type->name]);
        }

        return false;
    }

    public function clearFlash(): void
    {
        $this->session->delete(self::FLASH_KEY);
    }
}