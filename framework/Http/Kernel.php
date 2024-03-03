<?php

namespace Funbox\Framework\Http;

use Funbox\Framework\Routing\Router;

class Kernel
{
    public function __construct(private readonly Router $router)
    {
    }

    public function handle(Request $request): Response
    {

        try {
            [$routeHandler, $vars] = $this->router->dispatch($request);
            $response = call_user_func_array($routeHandler, $vars);
        } catch (\Exception $exception) {
            $response = new Response(content: $exception->getMessage(), status: $exception->getCode());
        }

        return $response;
    }

}
