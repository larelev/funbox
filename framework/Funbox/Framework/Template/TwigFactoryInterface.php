<?php

namespace Funbox\Framework\Template;

use Twig\Environment;

interface TwigFactoryInterface
{
    public function extendsTemplate(Environment $twig): Environment;
}