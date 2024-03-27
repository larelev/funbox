<?php

namespace Funbox\Framework\Http;

use Funbox\Framework\Session\SessionInterface;
use Funbox\Plugins\FlashMessage\FlashMessageInterface;

class Request implements RequestInterface
{
    private RequestInfo $info;
    private ?FlashMessageInterface $flashMessage = null;
    private ?SessionInterface $session = null;
    private mixed $routeHandler;
    private array  $routeHandlerArgs;

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

    public function getGetParams(string $param = ''): array
    {
        return $this->info->getGetParams($param);
    }

    public function getPostParams(string $param = ''): array
    {
        return $this->info->getPostParams($param);
    }

    public function getCookies(): array
    {
        return $this->info->getCookies();
    }

    public function getFiles(): array
    {
        return $this->info->getFiles();
    }

    public function getServer(): array
    {
        return $this->info->getServer();
    }

    public function getPathInfo(): string
    {
        return $this->info->getPathInfo();
    }

    public function getMethod(): string
    {
        return $this->info->getMethod();
    }

    public function getInfo(): RequestInfo
    {
        return $this->info;
    }

    public function __construct(
    )
    {
        $this->info = new RequestInfo();
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
