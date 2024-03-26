<?php

namespace Funbox\Plugins\Authentication\Middlewares;

use Funbox\Framework\Http\Request;
use Funbox\Framework\Http\Response;
use Funbox\Framework\Middleware\MiddlewareInterface;
use Funbox\Framework\Middleware\RequestHandlerInterface;

class Authentication implements MiddlewareInterface
{
    private bool $isAuthenticated = true;

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        if(!$this->isAuthenticated) {
            return new Response("Authentication failed!", 401);
        }

        return $handler->handle($request);
    }
}