<?php

namespace Funbox\Plugins\Authentication\Controllers;

use Funbox\Framework\Http\RedirectResponse;
use Funbox\Framework\Http\Response;
use Funbox\Framework\MVC\AbstractController;
use Funbox\Plugins\Authentication\Components\Authenticator;

class LoginController extends AbstractController
{
    public function __construct(private readonly Authenticator $authenticator)
    {
    }

    public function index(): Response
    {
        return $this->render('login.html.twig');
    }

    public function login(): Response
    {
        $isAuthenticated = $this->authenticator->authenticate(
            $this->request->searchFromBody('email'),
            $this->request->searchFromBody('password'),
        );

        if (!$isAuthenticated) {
            $this->request->getFlashMessage()->setError('Bad credentials.');
            return new RedirectResponse('/login');
        }

        $user = $this->authenticator->getUser();
        $this->request->getFlashMessage()->setSuccess('You are now logged in.');

        return new RedirectResponse('/dashboard');
    }

    public function logout(): Response
    {
        $this->authenticator->logout();
        $this->request->getFlashMessage()->setSuccess('See you soon!');

        return new RedirectResponse('/');
    }

}
