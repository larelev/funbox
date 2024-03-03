<?php

namespace Funbox\Framework\Routing;

use Funbox\Framework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request);
}
