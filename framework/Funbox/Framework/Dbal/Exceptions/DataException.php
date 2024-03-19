<?php

namespace Funbox\Framework\Dbal\Exceptions;

use Throwable;

class DataException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('A Data exception occurred with the message:%s %s', PHP_EOL, $message), $code, $previous);
    }
}