<?php

namespace Funbox\Plugins\Authentication;

use Funbox\Framework\Configuration\PluginConfigurationInterface;

class Config implements PluginConfigurationInterface
{

    public static function viewsPaths(): array
    {
        return [
            'views_path' => PLUGINS_PATH . 'Authentication' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR
        ];
    }
}