<?php

namespace Funbox\Framework\Http\Event;

use Funbox\Framework\Event\Event;

interface ResponseEventListenerInterface
{
    public function __invoke(ResponseEvent $event);
}