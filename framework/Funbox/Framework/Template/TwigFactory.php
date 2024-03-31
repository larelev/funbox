<?php

namespace Funbox\Framework\Template;

use Funbox\Framework\Session\Session;
use Twig\Environment;
use Twig\TwigFunction;

class TwigFactory extends AbstractTwigFactory
{

    public static function extendsTemplate(Environment $twig): Environment
    {
        $session = new Session();
        $twig->addFunction(new TwigFunction(
            'session',
            function () use ($session): Session
            {
                return $session;
            }
        ));

        $twig->addFunction(new TwigFunction(
            'csrfToken',
            function () use ($session): string
            {
                return $session->read(Session::CSRF_TOKEN);
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