<?php

namespace Funbox\Plugins\Authentication\Controllers;

use Funbox\Framework\Http\RedirectResponse;
use Funbox\Framework\Http\Response;
use Funbox\Framework\MVC\AbstractController;
use Funbox\Plugins\Authentication\Components\Authenticator;
use Funbox\Plugins\Authentication\Forms\RegistrationForm;
use Funbox\Plugins\Authentication\Repositories\UserMapper;

class RegistrationController extends AbstractController
{
    public function __construct(
        private readonly UserMapper $userMapper,
        private readonly Authenticator $authenticator,
    )
    {
    }

    public function index(): Response
    {
        return $this->render('register.html.twig');
    }

    public function register(): Response
    {
        $form = new RegistrationForm($this->userMapper);
        $form->setFields(
            $this->request->searchFromBody('email'),
            $this->request->searchFromBody('password'),
        );

        if($form->hasValidationErrors()) {
            foreach ($form->getValidationErrors() as $error) {
                $this->request->getFlashMessage()->setError($error);
            }

            return new RedirectResponse('/register');
        }

        $user = $form->save();

        $this->request->getFlashMessage()->setSuccess(
            'User %s created', $user->getEmail()
        );

        $this->authenticator->login($user);

        return new RedirectResponse('/dashboard');
    }

}