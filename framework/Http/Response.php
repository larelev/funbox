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
        http_response_code($this->status);
        echo $this->content;
    }
}
