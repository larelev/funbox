<?php

namespace Funbox\Framework\Http;

class Response
{
    public function __construct(
        private readonly ?string                  $content = '',
        private readonly HttpResponseCodeEnum|int $status = 200,
        private array                             $header = []
    )
    {
    }

    public function send(): void
    {
        $status = $this->status;
        if($this->status instanceof HttpResponseCodeEnum) {
            $status = $this->status->value;
        }
        http_response_code($status);
        echo $this->content;
    }
}
