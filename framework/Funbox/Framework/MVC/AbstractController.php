<?php

namespace Funbox\Framework\MVC;

use Funbox\Framework\Http\Request;
use Funbox\Framework\Http\Response;
use League\Container\DefinitionContainerInterface;

abstract class AbstractController
{
    protected ?DefinitionContainerInterface $container = null;

    public function __construct(
        protected readonly Request $request,
    )
    {

    }

    public function setContainer(DefinitionContainerInterface $container): void
    {
        if($this->container === null) {
            $this->container = $container;
        }
    }

    public function render(string $template, array $parameters = [], Response $response = null): Response
    {
        $req = $this->request;
        $content = $this->container->get('twig')->render($template, $parameters);

        $response ??= new Response();

        $response->setContent($content);

        return $response;
    }
}
