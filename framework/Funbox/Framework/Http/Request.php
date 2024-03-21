<?php

namespace Funbox\Framework\Http;

use Funbox\Widgets\FlashMessage\FlashMessageInterface;

class Request
{
    public readonly array $getParams;
    public readonly array $postParams;
    public readonly array $cookies;
    public readonly array $files;
    public readonly array $server;

    public readonly FlashMessageInterface $flashMessage;

    public function __construct(

    )
    {
        $this->getParams = $_GET;
        $this->postParams = $_POST;
        $this->cookies = $_COOKIE;
        $this->files = $_FILES;
        $this->server = $_SERVER;
    }

    public function getPathInfo(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function setFlashMessage(FlashMessageInterface $flashMessage)
    {
        $this->flashMessage = $flashMessage;
    }
}
