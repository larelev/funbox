<?php

namespace Funbox\Framework\Middleware;

use Funbox\Framework\Http\Request;
use Funbox\Framework\Http\Response;
use League\Container\DefinitionContainerInterface;

class RequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly DefinitionContainerInterface $container
    )
    {
    }

    private array $middleware = [
        FlashMessager::class,
        Authentication::class,
        RouterDispatcher::class,
    ];

    public function handle(Request $request): Response
    {
        if(empty($this->middleware)) {
            return new Response("No request to handle.", 500);
        }

        $middlewareClass = array_shift($this->middleware);

        $middleware = $this->container->get($middlewareClass);

        $response = $middleware->process($request, $this);

        return $response;
    }
}