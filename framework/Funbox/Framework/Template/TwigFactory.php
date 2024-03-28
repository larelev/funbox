<?php

namespace Funbox\Framework\Template;

use Twig\Environment;

class TwigFactory extends AbstractTwigFactory
{

    public function extendsTemplate(Environment $twig): Environment
    {
        return $twig;
    }
}