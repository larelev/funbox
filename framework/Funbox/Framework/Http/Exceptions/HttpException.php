<?php

namespace Funbox\Framework\Http\Exceptions;

use Throwable;

class HttpException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('An HTTP exception occurred with the message %s', $message), $code, $previous);
    }
}
