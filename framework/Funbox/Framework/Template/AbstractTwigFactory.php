<?php

namespace Funbox\Framework\Template;

use League\Container\DefinitionContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

abstract class AbstractTwigFactory
{

    public function create(): Environment
    {
        $templatesPaths = $this->getViewsPaths();
        $loader = new FilesystemLoader($templatesPaths);

        $twig = new Environment($loader, [
            'debug' => true,
            'cache' => false,
        ]);
        $twig->addExtension(new DebugExtension());

        return $this->extendsTemplate($twig);
    }

    public abstract function extendsTemplate(Environment $twig): Environment;

    public function getViewsPaths(): array
    {
        $viewsPaths = [APP_VIEWS_PATH];

        $filename = CONFIG_PATH . 'twig.php';
        if(file_exists($filename)) {
            $viewsPaths = include $filename;
        }

        return $viewsPaths;
    }

}