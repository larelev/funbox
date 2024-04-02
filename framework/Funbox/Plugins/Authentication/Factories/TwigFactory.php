<?php

namespace Funbox\Plugins\Authentication\Factories;

use Funbox\Framework\Session\Session;
use Funbox\Framework\Template\TwigFactoryInterface;
use Funbox\Plugins\Authentication\Components\Authenticator;
use Twig\Environment;
use Twig\TwigFunction;

class TwigFactory implements TwigFactoryInterface
{

    public static function extendsTemplate(Environment $twig): Environment
    {
        $session = new Session();
        $twig->addFunction(new TwigFunction(
            'isLoggedIn',
            function () use ($session): bool
            {
                return Authenticator::hasLoggedIn($session);
            }
        ));

        $twig->addFunction(new TwigFunction(
            'csrfToken',
            function () use ($session): string
            {
                return $session->read(Session::CSRF_TOKEN) ?? '';
            }
        ));

        $twig->addFunction(new TwigFunction(
            'csrfFieldName',
            function (): string
            {
                return Session::CSRF_TOKEN;
            }
        ));
        return $twig;
    }
}