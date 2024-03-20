<?php

namespace App\Controllers;

use App\widgets\Widget;
use Funbox\Framework\Http\Response;
use Funbox\Framework\MVC\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(private Widget $widget)
    {
    }

    public function index(): Response
    {
        return $this->render('home.html.twig', ['name' => $this->widget->name]);
    }
}
