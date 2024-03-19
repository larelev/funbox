<?php

namespace Funbox\Framework\Http\Exceptions;

use Throwable;

class HttpNotFoundException extends HttpException
{
    public function __construct(string $message = '', ?Throwable $previous = null)
    {
        parent::__construct(sprintf($message, 404, $previous));
    }
}
