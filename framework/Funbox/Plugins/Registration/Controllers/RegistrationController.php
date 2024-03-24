<?php

namespace Funbox\Plugins\Registration\Controllers;

use Funbox\Framework\Http\Response;
use Funbox\Framework\MVC\AbstractController;
use Funbox\Plugins\Registration\Forms\RegistrationForm;

class RegistrationController extends AbstractController
{
    public function __construct()
    {
    }

    public function index(): Response
    {
        return $this->render('register.html.twig');
    }

    public function register(): Response
    {
        $form = new RegistrationForm();
        $form->setFields(
            $this->request->searchFromBody('login'),
            $this->request->searchFromBody('password'),
        );
    }
}