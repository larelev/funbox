<?php

namespace Funbox\Framework\Http;

use Funbox\Framework\Http\Exceptions\HttpException;
use Funbox\Framework\Http\Exceptions\HttpRequestMethodException;
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
        } catch (HttpException $exception) {
            $response = new Response(content: $exception->getMessage(), status: $exception->getCode());
        } catch (\Exception $exception) {
            $response = new Response(content: $exception->getMessage(), status: HttpResponseCodeEnum::SERVER_ERROR);
        }

        return $response;
    }

}
