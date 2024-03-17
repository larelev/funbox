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

        $definition = $container->add(\Funbox\Framework\MVC\AbstractController::class);
        $definition->addArgument($request);

        $container->inflector(\Funbox\Framework\MVC\AbstractController::class)
            ->invokeMethod('setContainer', [$container]);


        $kernel = $container->get(Kernel::class);
        $response = $kernel->handle($request);
        $response->send();
    }

    public static function create(): static
    {
       $clasName = get_class();
       return new $clasName;
    }
}
