<?php

namespace Funbox\Framework\Middleware;

use Funbox\Framework\Http\Request;
use Funbox\Framework\Http\Response;
use Funbox\Widgets\FlashMessage\FlashMessageInterface;

class FlashMessager implements MiddlewareInterface
{

    public function __construct(
        private readonly FlashMessageInterface $flashMessage
    )
    {
    }

    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        $request->setFlashMessage($this->flashMessage);

        return $requestHandler->handle($request);
    }
}