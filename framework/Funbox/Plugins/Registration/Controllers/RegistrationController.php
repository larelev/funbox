<?php

namespace Funbox\Plugins\Registration\Controllers;

use Funbox\Framework\Http\Response;
use Funbox\Framework\MVC\AbstractController;

class RegistrationController extends AbstractController
{
    public function __construct()
    {
    }

    public function index(): Response
    {
        return $this->render('register.html.twig');
    }
}