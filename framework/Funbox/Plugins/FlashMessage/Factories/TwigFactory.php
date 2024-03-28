<?php

namespace Funbox\Plugins\FlashMessage\Factories;

use Funbox\Framework\Template\TwigFactoryInterface;
use Funbox\Plugins\FlashMessage\FlashMessage;
use Funbox\Plugins\FlashMessage\FlashMessageInterface;
use Twig\Environment;
use Twig\TwigFunction;

class TwigFactory implements TwigFactoryInterface
{

    public static function extendsTemplate(Environment $twig): Environment
    {
        $flashMessage = new FlashMessage();
        $twig->addFunction(new TwigFunction(
            'flashMessage',
            function() use($flashMessage): FlashMessageInterface
            {
                return $flashMessage;
            }
        ));

        return $twig;
    }
}