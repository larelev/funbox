<?php

namespace Funbox\Framework\Web;

use Funbox\Framework\Core\AbstractApplication;
use \Funbox\Framework\Http\Request;
use \Funbox\Framework\Http\Kernel;
use Funbox\Framework\Routing\Router;

class WebApplication extends AbstractApplication
{
    public function __construct()
    {
        $this->run();
    }

    function run(): void
    {

        $container = require CONFIG_PATH . 'services.php';

        $request = Request::createFromGlobals();
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
