<?php

namespace App\Controllers;

use Funbox\Framework\Http\Response;

class HomeController
{
    function index(): Response
    {
        return new Response(content: <<< HTML
                    <h1>Hello world!</h1>
                    HTML);
    }
}