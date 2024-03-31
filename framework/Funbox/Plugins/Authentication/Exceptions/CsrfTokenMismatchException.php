<?php

namespace Funbox\Plugins\Authentication\Exceptions;

use Funbox\Framework\Http\Exceptions\HttpException;
use Funbox\Framework\Http\HttpStatusCodeEnum;
use Throwable;

class CsrfTokenMismatchException extends HttpException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct(
            'Your request could not be validated. Please try again.',
            HttpStatusCodeEnum::FORBIDDEN_ACCESS,
            $previous,
        );
    }
}