<?php

namespace Stella\Core\Http\Response;

abstract class Response
{
    public function __construct(
        private int $statusCode = 200,
        private array $headers = [],
    ) {}

    abstract protected function getContent(): string;

    final public function content(): string
    {
        return $this->getContent();
    }

    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        echo $this->content();
    }

    public function withHeader(string $name, string $value): static
    {
        $headers = $this->headers;
        $headers[$name] = $value;

        return new static($this->statusCode, $headers);
    }

    public function withHeaders(array $headers): static
    {
        return new static($this->statusCode, [...$this->headers, ...$headers]);
    }

    public function withStatusCode(int $statusCode): static
    {
        return new static($statusCode, $this->headers);
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    public function headers(): array
    {
        return $this->headers;
    }
}
