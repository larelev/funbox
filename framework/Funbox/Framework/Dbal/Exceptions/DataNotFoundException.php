<?php

namespace Funbox\Framework\Dbal\Exceptions;

use Throwable;

class DataNotFoundException extends DataException
{
    public function __construct(string $message = "", ?Throwable $previous = null)
    {
        parent::__construct($message . " not found!", 404, $previous);
    }
}