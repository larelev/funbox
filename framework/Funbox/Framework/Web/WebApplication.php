<?php

namespace Funbox\Framework\Web;

use App\events\ContentLengthListener;
use App\Events\InternalErrorListener;
use Funbox\Framework\Core\AbstractApplication;
use Funbox\Framework\Event\EventDispatcher;
use Funbox\Framework\Http\Event\ResponseEvent;
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

        $container = require BASE_PATH . 'bootstrap' . DIRECTORY_SEPARATOR . 'bootstrap.php';

        $container->add(\Funbox\Framework\MVC\AbstractController::class);

        $inflector = $container->inflector(\Funbox\Framework\MVC\AbstractController::class);
        $inflector->invokeMethod('setContainer', [$container]);
        $inflector->invokeMethod('setRequest', [$request]);

        $container->addShared(
            \Funbox\Framework\Http\HistoryInterface::class,
            \Funbox\Framework\Http\History::class,
        );

        $filename = BASE_PATH . 'factories' . DIRECTORY_SEPARATOR . 'TwigFactory.php';
        if(!file_exists($filename)) {
            $container->add('template-renderer-factory', \Funbox\Framework\Template\TwigFactory::class);
        }

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
