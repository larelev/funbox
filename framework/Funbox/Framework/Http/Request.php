<?php

namespace Funbox\Framework\Http;

use Funbox\Framework\Session\SessionInterface;
use Funbox\Plugins\FlashMessage\FlashMessageInterface;

class Request
{
    private ?FlashMessageInterface $flashMessage = null;
    private ?SessionInterface $session = null;

    public readonly array $getParams;
    public readonly array $postParams;
    public readonly array $cookies;
    public readonly array $files;
    public readonly array $server;

    private mixed $routeHandler;
    private array  $routeHandlerArgs;

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

    public function getRouteHandler(): mixed
    {
        return $this->routeHandler;
    }

    public function setRouteHandler(mixed $routeHandler): void
    {
        $this->routeHandler = $routeHandler;
    }

    public function getRouteHandlerArgs(): array
    {
        return $this->routeHandlerArgs;
    }

    public function setRouteHandlerArgs(array $routeHandlerArgs): void
    {
        $this->routeHandlerArgs = $routeHandlerArgs;
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

    public function searchFromQuery(string $param): ?string
    {
        return !isset($this->getParams[$param]) ? null : $this->getParams[$param];
    }

    public function searchFromBody(string $param): ?string
    {
        return !isset($this->postParams[$param]) ? null : $this->postParams[$param];
    }
}
