<?php

namespace Funbox\Plugins\Authentication\Middlewares;

use Funbox\Framework\Http\HistoryInterface;
use Funbox\Framework\Http\RedirectResponse;
use Funbox\Framework\Http\Request;
use Funbox\Framework\Http\Response;
use Funbox\Framework\Middleware\MiddlewareInterface;
use Funbox\Framework\Middleware\RequestHandlerInterface;
use Funbox\Framework\Session\SessionInterface;

class Guest implements MiddlewareInterface
{
    private bool $isAuthenticated = true;

    public function __construct(
        private readonly SessionInterface $session,
        private readonly HistoryInterface $history,
    ) {
    }

    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        $this->session->start();
        $this->history->set($request->getInfo());
        $lastGetRequest = $this->history->getLastGetRequest();
        $pathname = $lastGetRequest->getPathInfo();

        if ($pathname == '/login' || $pathname == '/register') {
            $pathname = '/dashboard';
        }

        if ($this->session->has(\Funbox\Plugins\Authentication\Authentication::AUTH_KEY)) {
            return new RedirectResponse($pathname);
        }

        return $requestHandler->handle($request);
    }
}
