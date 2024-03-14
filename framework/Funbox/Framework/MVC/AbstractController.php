<?php

namespace Funbox\Framework\MVC;

use Funbox\Framework\Http\Response;
use League\Container\DefinitionContainerInterface;

abstract class AbstractController
{
    protected ?DefinitionContainerInterface $container = null;

    public function setContainer(DefinitionContainerInterface $container): void
    {
        $this->container = $container;
    }

    public function render(string $template, array $parameters = [], Response $response = null): Response
    {
        $content = $this->container->get('twig')->render($template, $parameters);

        $response ??= new Response();

        $response->setContent($content);

        return $response;
    }
}
