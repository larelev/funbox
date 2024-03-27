<?php

namespace App\Factories;

use Funbox\Framework\Logger\Logger;
use Funbox\Framework\Session\Session;
use Funbox\Framework\Session\SessionInterface;
use Funbox\Framework\Template\AbstractTwigFactory;
use Funbox\Plugins\Authentication\Components\Authenticator;
use Funbox\Plugins\Authentication\Components\AuthenticatorInterface;
use Funbox\Plugins\FlashMessage\FlashMessage;
use Funbox\Plugins\FlashMessage\FlashMessageInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\TwigFunction;

class TwigFactory extends AbstractTwigFactory
{
    private FlashMessageInterface $flashMessage;
    private SessionInterface $session;

    public function extendsTemplate(Environment $twig): Environment
    {
        $this->session = new Session();
        $this->flashMessage = new FlashMessage();
        $twig->addFunction(new TwigFunction('flashMessage', [$this, 'getFlashMessage']));
        $twig->addFunction(new TwigFunction('isLoggedIn', [$this, 'hasLoggedIn']));

        return $twig;
    }

    public function getFlashMessage(): FlashMessageInterface
    {
        return $this->flashMessage;
    }

    public function hasLoggedIn(): bool
    {
        return Authenticator::hasLoggedIn($this->session);
    }
}