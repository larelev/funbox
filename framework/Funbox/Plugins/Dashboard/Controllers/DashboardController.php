<?php

namespace Funbox\Plugins\Dashboard\Controllers;

use Funbox\Framework\Http\Response;
use Funbox\Framework\MVC\AbstractController;

class DashboardController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('dashboard.html.twig');
    }
}