<?php

namespace Stella\Core\Http\Response;

abstract class Response
{
    public function __construct(
        private int $statusCode = 200,
        private array $headers = []
    )
    {
    }

    abstract protected function getContent(): string;

    public function setStatusCode(int $code): self
    {
        $this->statusCode = $code;
        return $this;
    }

    public function setHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        echo $this->getContent();
    }
}
