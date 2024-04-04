<?php

namespace Funbox\Plugins\Authentication\Middlewares;

use Funbox\Framework\Http\RedirectResponse;
use Funbox\Framework\Http\Request;
use Funbox\Framework\Http\Response;
use Funbox\Framework\Middleware\MiddlewareInterface;
use Funbox\Framework\Middleware\RequestHandlerInterface;
use Funbox\Framework\Session\SessionInterface;
use Funbox\Plugins\FlashMessage\FlashMessageInterface;

class Authentication implements MiddlewareInterface
{
    private bool $isAuthenticated = true;

    public function __construct(
        private readonly SessionInterface $session,
        private readonly FlashMessageInterface $flashMessage,
    ) {
    }

    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        $this->session->start();
        if (!$this->session->has(\Funbox\Plugins\Authentication\Authentication::AUTH_KEY)) {
            $this->flashMessage->setError('Please sign in.');
            return new RedirectResponse("/login");
        }

        return $requestHandler->handle($request);
    }
}
