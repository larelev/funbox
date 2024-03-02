<?php declare(strict_types=1);

require_once "bootstrap.php";

use \Funbox\Framework\Http\Request;
use \Funbox\Framework\Http\Response;
use \Funbox\Framework\Http\Kernel;

// dd(Request::createFromGlobals());

$request = Request::createFromGlobals();

$kernel = new Kernel();

$response = $kernel->handle($request);

//$response = new Response(content: <<< HTML
//    <h1>Hello world!</h1>
//    HTML);

$response->send();
