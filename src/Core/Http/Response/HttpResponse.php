<?php

namespace Stella\Core\Http\Response;

class HttpResponse implements Response
{
    public function __construct(
        private int $statusCode = 200,
        private array $headers = [],
    ) {}

    protected function getContent(): string
    {
        return '';
    }

    final public function body(): string
    {
        return $this->getContent();
    }

    public function withHeader(string $name, string $value): static
    {
        $clone = clone $this;
        $clone->headers[$name] = $value;

        return $clone;
    }

    public function withHeaders(array $headers): static
    {
        $clone = clone $this;
        $clone->headers = [...$this->headers, ...$headers];

        return $clone;
    }

    public function withStatusCode(int $statusCode): static
    {
        $clone = clone $this;
        $clone->statusCode = $statusCode;

        return $clone;
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
