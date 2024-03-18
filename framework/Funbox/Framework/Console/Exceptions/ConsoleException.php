<?php

namespace Funbox\Framework\Console\Exceptions;

use Throwable;

class ConsoleException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct((sprintf('An Console exception occurred with the message %s', $message), $code, $previous);
    }
}