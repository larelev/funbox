<?php

namespace Funbox\Framework\Container\Exceptions;

use Psr\Container\ContainerExceptionInterface;
use Throwable;

class ContainerException extends \Exception implements ContainerExceptionInterface
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('An Container exception occurred with the message %s', $message), $code, $previous);
    }
}
