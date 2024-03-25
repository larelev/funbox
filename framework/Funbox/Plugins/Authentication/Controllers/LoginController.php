<?php

namespace Funbox\Plugins\Authentication\Controllers;

use Funbox\Framework\Http\RedirectResponse;
use Funbox\Framework\Http\Response;
use Funbox\Framework\MVC\AbstractController;
use Funbox\Plugins\Authentication\Forms\RegistrationForm;
use Funbox\Plugins\Authentication\Repositories\UserMapper;

class LoginController extends AbstractController
{
    public function __construct(private readonly UserMapper $userMapper)
    {
    }

    public function index(): Response
    {
        return $this->render('login.html.twig');
    }

    public function login(): Response
    {
        return new RedirectResponse('/');
    }

}