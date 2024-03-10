<?php

namespace Funbox\Framework\Http;

class Response
{
    public function __construct(
        private ?string                  $content = '',
        private readonly HttpStatusCodeEnum|int $status = 200,
        private array                             $header = [],
    )
    {
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function send(): void
    {
        $status = $this->status;
        if($this->status instanceof HttpStatusCodeEnum) {
            $status = $this->status->value;
        }
        http_response_code($status);
        echo $this->content;
    }


}
