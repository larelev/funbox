<?php

namespace Funbox\Plugins\FlashMessage\Middlewares;

use Funbox\Framework\Http\Request;
use Funbox\Framework\Http\Response;
use Funbox\Framework\Middleware\MiddlewareInterface;
use Funbox\Framework\Middleware\RequestHandlerInterface;
use Funbox\Plugins\FlashMessage\FlashMessageInterface;

readonly class FlashMessenger implements MiddlewareInterface
{

    public function __construct(
        private FlashMessageInterface $flashMessage
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        $request->setFlashMessage($this->flashMessage);

        return $requestHandler->handle($request);
    }
}