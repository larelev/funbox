<?php

namespace Funbox\Framework\Http;

use Funbox\Framework\Exceptions\HttpException;
use Funbox\Framework\Routing\RouterInterface;
use Psr\Container\ContainerInterface;

class Kernel
{
    private string $appEnv;

    public function __construct(
        private readonly RouterInterface $router,
        private readonly ContainerInterface $container
    )
    {
        $this->appEnv = $this->container->get('APP_ENV');
    }

    public function handle(Request $request): Response
    {
        try {
            [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);
            $response = call_user_func_array($routeHandler, $vars);
        } catch (\Exception $exception) {
            $response = $this->createExceptionResponse($exception);
        }

        return $response;
    }

    public function createExceptionResponse(\Exception $exception): Response
    {
        if(in_array($this->appEnv, ['dev', 'test'])) {
            throw $exception;
        }

        if($exception instanceof HttpException) {
            $response = new Response(content: $exception->getMessage(), status: $exception->getCode());
        }

        return new Response(content: 'Server error!', status: HttpStatusCodeEnum::SERVER_ERROR);
    }
}
