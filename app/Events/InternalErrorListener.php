<?php

namespace App\Events;

use Funbox\Framework\Http\Event\ResponseEvent;
use Funbox\Framework\Http\Event\ResponseEventListenerInterface;

class InternalErrorListener implements ResponseEventListenerInterface
{

    public function __invoke(ResponseEvent $event)
    {
        $status = $event->getResponse()->getStatus();
        if ($status > 499) {
            $event->stopPropagation();
        }
    }
}
