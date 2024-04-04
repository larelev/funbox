<?php

namespace Funbox\Framework\Core;

use Throwable;

class BaseException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, null|Throwable $previous = null, ...$params)
    {
        parent::__construct(sprintf($message, ...$params), $code, $previous);
    }
}