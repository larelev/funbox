<?php

namespace Funbox\Framework\Middleware;

use Funbox\Framework\Http\Request;
use Funbox\Framework\Http\Response;

class Authentication implements MiddlewareInterface
{
    private bool $isAuthenticated = true;

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        // TODO: Implement process() method.
        if(!$this->isAuthenticated) {
            return new Response("Authentication failed!", 401);
        }

        return $handler->handle($request);
    }
}