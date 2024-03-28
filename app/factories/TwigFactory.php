<?php

namespace App\Factories;

use Funbox\Framework\Template\AbstractTwigFactory;
use Twig\Environment;

class TwigFactory extends AbstractTwigFactory
{
    public function extendsTemplate(Environment $twig): Environment
    {
        $twig = \Funbox\Plugins\Authentication\Factories\TwigFactory::extendsTemplate($twig);
        $twig = \Funbox\Plugins\FlashMessage\Factories\TwigFactory::extendsTemplate($twig);

        return $twig;
    }

}