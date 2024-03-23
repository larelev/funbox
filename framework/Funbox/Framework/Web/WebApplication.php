<?php

namespace Funbox\Framework\Web;

use Funbox\Framework\Core\AbstractApplication;
use Funbox\Framework\Http\Kernel;
use Funbox\Framework\Http\Request;

class WebApplication extends AbstractApplication
{
    public function __construct()
    {
        $this->run();
    }

    function run(): void
    {
        $request = new Request();

        $container = require SERVICES_PATH;

        $container->add(\Funbox\Framework\MVC\AbstractController::class);

        $inflector = $container->inflector(\Funbox\Framework\MVC\AbstractController::class);
        $inflector->invokeMethod('setContainer', [$container]);
        $inflector->invokeMethod('setRequest', [$request]);

        $viewsPaths = include CONFIG_PATH . 'twig.php';

        $container->add('template-renderer-factory', \Funbox\Framework\Template\TwigFactory::class)
            ->addArguments([
                \Funbox\Plugins\FlashMessage\FlashMessageInterface::class,
                new \League\Container\Argument\Literal\ArrayArgument($viewsPaths),
            ]);

        $container->addShared('twig', function () use ($container) {
            return $container->get('template-renderer-factory')->create();
        });

        $kernel = $container->get(Kernel::class);
        $response = $kernel->handle($request);
        $response->send();

        $kernel->terminate($request, $response);

    }

    public static function create(): static
    {
       $clasName = WebApplication::class;
       return new $clasName;
    }
}
