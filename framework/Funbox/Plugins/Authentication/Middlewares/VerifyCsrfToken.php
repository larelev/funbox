<?php

namespace Funbox\Plugins\Authentication\Middlewares;

use Funbox\Framework\Http\Request;
use Funbox\Framework\Http\Response;
use Funbox\Framework\Middleware\MiddlewareInterface;
use Funbox\Framework\Middleware\RequestHandlerInterface;
use Funbox\Framework\Session\Session;

class VerifyCsrfToken implements MiddlewareInterface
{

    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        if($request->getMethod() == 'GET') {
            return $requestHandler->handle($request);
        }

        $sessionToken = $request->getSession()->read(Session::CSRF_TOKEN);
        $formToken = $request->searchFromBody(Session::CSRF_TOKEN);

        if(!hash_equals($sessionToken, $formToken)) {

        }
    }
}