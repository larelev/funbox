<?php

namespace Funbox\Framework\Template;

use Funbox\Plugins\FlashMessage\FlashMessageInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class TwigFactory
{
    public function __construct(
        private FlashMessageInterface $flashMessage,
        private array $templatePaths
    )
    {
    }

    public function create(): Environment
    {
        $loader = new FilesystemLoader($this->templatePaths);

        $twig = new Environment($loader, [
            'debug' => true,
            'cache' => false,
        ]);

        $twig->addExtension(new DebugExtension());
        $twig->addFunction(new TwigFunction('flashMessage', [$this, 'getFlashMessage']));

        return $twig;
    }

    public function getFlashMessage(): FlashMessageInterface
    {
        return $this->flashMessage;
    }

}