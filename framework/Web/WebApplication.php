<?php

namespace Funbox\Framework\Web;

use Funbox\Framework\Core\AbstractApplication;
use \Funbox\Framework\Http\Request;
use \Funbox\Framework\Http\Kernel;

class WebApplication extends AbstractApplication
{
    public function __construct()
    {
        $this->run();
    }

    function run(): void
    {
        $request = Request::createFromGlobals();
        $kernel = new Kernel();
        $response = $kernel->handle($request);
        $response->send();
    }

    public static function create(): static
    {
       $clasName = get_class();
       return new $clasName;
    }
}