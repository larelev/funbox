<?php

namespace App\Controllers;

use App\Widgets\Dummy;
use Funbox\Framework\Http\Response;
use Funbox\Framework\MVC\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(private Dummy $widget)
    {
    }

    public function index(): Response
    {
        return $this->render('home.html.twig', ['name' => $this->widget->name]);
    }
}
