<?php

namespace Funbox\Framework\Http;

class Response
{
    public function __construct(
        private ?string                  $content = '',
        private readonly HttpStatusCodeEnum|int $status = 200,
        private array                             $headers = [],
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

    public function getStatus(): int|HttpStatusCodeEnum
    {
        $status = $this->status;
        if($this->status instanceof HttpStatusCodeEnum) {
            $status = $this->status->value;
        }
        return $status;
    }

    public function send(): void
    {
        http_response_code($this->getStatus());
        echo $this->content;
    }

    protected function buildHeaders(): array
    {
        $result = [];
        foreach ($this->headers as $key => $value) {
            $result[] = "$key: " . $value;
        }

        return $result;
    }

    /**
     * @throws \Exception
     */
    protected function buildHeader(string $header): string
    {
        $result = '';
        foreach ($this->headers as $key => $value) {
            if($key == $header) {
                $result = "$key: " . $value;
                break;
            }
        }

        if($result == '') {
            throw new \Exception('Header not found!');
        }

        return $result;
    }

}
