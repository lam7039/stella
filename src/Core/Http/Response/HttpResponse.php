<?php

namespace Stella\Core\Http\Response;

class HttpResponse implements Response
{
    public function __construct(
        private int $statusCode = 200,
        private array $headers = [],
    ) {
        $this->validateStatusCode($statusCode);
        $this->validateHeaders($headers);
    }

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
        $this->validateHeader($name, $value);

        $clone = clone $this;
        $clone->headers[$name] = $value;

        return $clone;
    }

    public function withHeaders(array $headers): static
    {
        $this->validateHeaders($headers);

        $clone = clone $this;
        $clone->headers = [...$this->headers, ...$headers];

        return $clone;
    }

    public function withStatusCode(int $statusCode): static
    {
        $this->validateStatusCode($statusCode);

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

    private function validateStatusCode(int $statusCode): void
    {
        if ($statusCode < 100 || $statusCode > 599) {
            throw new \InvalidArgumentException('Invalid HTTP status code: ' . $statusCode);
        }
    }

    private function validateHeaders(array $headers): void
    {
        foreach ($headers as $name => $value) {
            $this->validateHeader($name, $value);
        }
    }

    private function validateHeader(string $name, string $value): void
    {
        if ($name === '' || preg_match("/^[!#$%&'*+.^_`|~0-9A-Za-z-]+$/D", $name) !== 1) {
            throw new \InvalidArgumentException('Invalid HTTP header name: ' . $name);
        }

        if (preg_match('/[\r\n]/', $value) === 1) {
            throw new \InvalidArgumentException('Invalid HTTP header value: ' . $value);
        }
    }
}
