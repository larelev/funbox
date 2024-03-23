<?php

namespace Funbox\Plugins\Registration\Routes;

use Funbox\Framework\Routing\RoutesCollectionInterface;

class Web implements RoutesCollectionInterface
{
    public static function collection(): array
    {
        return [
            ['GET', '/register', [\Funbox\Plugins\Registration\Controllers\RegistrationController::class, 'index']],
        ];
    }
}