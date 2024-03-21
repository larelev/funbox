<?php

namespace Funbox\Framework\Middleware;

use Funbox\Framework\Http\Request;
use Funbox\Framework\Http\Response;
use Funbox\Framework\Session\SessionInterface;
use Funbox\Widgets\FlashMessage\FlashMessageInterface;

readonly class SessionManager implements MiddlewareInterface
{

    public function __construct(
        private SessionInterface $session
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        $request->setSession($this->session);

        return $requestHandler->handle($request);
    }
}