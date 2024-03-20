<?php

namespace Funbox\Framework\Template;

use App\idgets\FlashMessage\FlashMessageInterface;
use Funbox\Framework\Session\SessionInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class TwigFactory
{
    public function __construct(
        private FlashMessageInterface $flashMessage,
        private string $templatePath
    )
    {
    }

    public function create(): Environment
    {
        $loader = new FilesystemLoader($this->templatePath);

        $twig = new Environment($loader, [
            'debug' => true,
            'cache' => false,
        ]);

        $twig->addExtension(new DebugExtension());
        $twig->addFunction(new TwigFunction('flashMessage', [$this, 'getFlasMessage']));
    }

    public function getFlashMesage(): FlashMessageInterface
    {
        return $this->flashMessage;
    }

}