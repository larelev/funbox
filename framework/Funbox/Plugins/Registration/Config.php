<?php

namespace Funbox\Plugins\Registration;

use Funbox\Framework\Configuration\PluginConfigurationInterface;

class Config implements PluginConfigurationInterface
{

    public static function viewsPaths(): array
    {
        return [
            'views_path' => PLUGINS_PATH . 'Registration' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR
        ];
    }
}