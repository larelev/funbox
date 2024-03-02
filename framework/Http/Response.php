<?php

namespace Funbox\Framework\Http;

class Response
{
    public function __construct(
        private ?string $content = '',
        private int $status = 200,
        private array $header = []
    )
    {
    }

    public function send()
    {
        echo $this->content;
    }
}
