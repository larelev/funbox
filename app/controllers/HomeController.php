<?php

namespace App\Controllers;

use Funbox\Framework\Http\Response;
use Funbox\Framework\MVC\AbstractController;

class HomeController extends AbstractController
{
<<<<<<< HEAD
    function index(): Response
    {
        return new Response(content: <<< HTML
                    <h1>Hello world!</h1>
                    HTML);
=======
    public function __construct(private Widget $widget)
    {
    }

    public function index(): Response
    {
        return $this->render('Home.html.twig', ['name' => $this->widget->name]);
>>>>>>> 2e5f5be (Adds twig support)
    }
}