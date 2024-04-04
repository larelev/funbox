<?php

namespace App\Repositories\Exceptions;

use Funbox\Framework\Dbal\Exceptions\DataNotFoundException;

class PostNotFoundException extends DataNotFoundException
{

    public function __construct(int $postId, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Post %d', $postId), $previous);
    }
}
