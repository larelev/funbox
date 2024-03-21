<?php

namespace Funbox\Framework\Http;

use Funbox\Framework\Session\SessionInterface;
use Funbox\Widgets\FlashMessage\FlashMessageInterface;

class Request
{
    private ?FlashMessageInterface $flashMessage = null;
    private ?SessionInterface $session = null;

    public readonly array $getParams;
    public readonly array $postParams;
    public readonly array $cookies;
    public readonly array $files;
    public readonly array $server;

    public function getPathInfo(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function getSession(): ?SessionInterface
    {
        return $this->session;
    }
    public function setSession(?SessionInterface $session): void
    {
        if($this->session !== null) {
            throw new \Exception("Session already instantiated.");
        }
        $this->session = $session;
    }

    public function getFlashMessage(): ?FlashMessageInterface
    {
        return $this->flashMessage;
    }
    public function setFlashMessage(?FlashMessageInterface $flashMessage)
    {
        if($this->flashMessage !== null) {
            throw new \Exception("FlashMessage already instantiated.");
        }
        $this->flashMessage = $flashMessage;
    }


    public function __construct(
    )
    {
        $this->getParams = $_GET;
        $this->postParams = $_POST;
        $this->cookies = $_COOKIE;
        $this->files = $_FILES;
        $this->server = $_SERVER;
    }




}
