<?php

namespace App\Controllers;

use App\Widgets\Widget;
use Funbox\Framework\Http\Response;

class HomeController
{
    public function __construct(private Widget $widget)
    {

    }
    public function index(): Response
    {
        return new Response(content: <<< HTML
                    <h1>Hello {$this->widget->name}!</h1>
                    HTML);
    }
}
