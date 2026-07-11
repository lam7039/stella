<?php

namespace Stella\Core\Http;

//TODO: split methods off into traits
class Request
{
    private readonly ?RequestMethod $method;
    private readonly array $headers;

    private readonly array $post;
    private readonly array $query;

    private readonly array $json;
    private readonly string $body;

    private readonly array $input;

    public function __construct()
    {
        $this->method = RequestMethod::tryFrom($_SERVER['REQUEST_METHOD'] ?? '');
        $this->headers = $this->loadHeaders();

        $this->post = $_POST;
        $this->query = $_GET;

        [$this->body, $this->json] = $this->parseJson();

        $this->input = array_merge($this->query, $this->post, $this->json);
    }

    public function post(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }

    public function query(string $key, mixed $default = null): mixed
    {
        return $this->query[$key] ?? $default;
    }

    public function json(string $key, mixed $default = null): mixed
    {
        return $this->json[$key] ?? $default;
    }

    public function rawBody(): string
    {
        return $this->body;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return array_key_exists($key, $this->input) ? $this->input[$key] : $default;
    }

    public function all(): array
    {
        return $this->input;
    }

    public function except(array $keys): array
    {
        return array_diff_key($this->all(), array_flip($keys));
    }

    public function only(array $keys): array
    {
        return array_intersect_key($this->all(), array_flip($keys));
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->input);
    }

    public function uri(): string
    {
        return $_SERVER['REQUEST_URI'] ?? '/';
    }

    public function fullUrl(): string
    {
        return sprintf(
            '%s://%s%s',
            $this->scheme(),
            $this->host(),
            $this->uri()
        );
    }

    public function path(): string
    {
        return parse_url($this->uri(), PHP_URL_PATH) ?: '/';
    }

    public function url(): string
    {
        return sprintf(
            '%s://%s%s',
            $this->scheme(),
            $this->host(),
            $this->path()
        );
    }

    public function method(): ?RequestMethod
    {
        return $this->method;
    }

    public function isMethod(RequestMethod $method): bool
    {
        return $this->method === $method;
    }

    public function isGet(): bool
    {
        return $this->isMethod(RequestMethod::GET);
    }

    public function isPost(): bool
    {
        return $this->isMethod(RequestMethod::POST);
    }

    public function isPut(): bool
    {
        return $this->isMethod(RequestMethod::PUT);
    }

    public function isPatch(): bool
    {
        return $this->isMethod(RequestMethod::PATCH);
    }

    public function isOptions(): bool
    {
        return $this->isMethod(RequestMethod::OPTIONS);
    }

    public function isDelete(): bool
    {
        return $this->isMethod(RequestMethod::DELETE);
    }

    public function isJson(): bool
    {
        return str_starts_with(
            $this->header('Content-Type', ''),
            'application/json'
        );
    }

    public function acceptsJson(): bool
    {
        return str_contains(
            $this->header('Accept', ''),
            'application/json'
        );
    }

    public function header(string $name, mixed $default = null): mixed
    {
        foreach ($this->headers as $key => $value) {
            if (strcasecmp($key, $name) === 0) {
                return $value;
            }
        }

        return $default;
    }

    public function bearerToken(): ?string
    {
        $header = $this->header('Authorization');

        if (! $header || ! str_starts_with($header, 'Bearer ')) {
            return null;
        }

        return substr($header, 7);
    }

    public function ip(): ?string
    {
        return $_SERVER['REMOTE_ADDR'] ?? null;
    }

    private function parseJson(): array
    {
        if (! $this->isJson()) {
            return ['', []];
        }

        $body = file_get_contents('php://input') ?: '';

        try {
            $json = json_decode(
                json: $body,
                associative: true,
                flags: JSON_THROW_ON_ERROR
            );
        } catch (\JsonException $e) {
            $json = [];
        }

        return [
            $body,
            is_array($json) ? $json : []
        ];
    }

    private function scheme(): string
    {
        return (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    }

    private function host(): string
    {
        return $_SERVER['HTTP_HOST'] ?? '';
    }

    private function loadHeaders(): array
    {
        if (function_exists('getallheaders')) {
            return getallheaders();
        }

        $headers = [];

        foreach ($_SERVER as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $name = str_replace('_', '-', substr($key, 5));
                $headers[$name] = $value;
            }
        }

        if (isset($_SERVER['CONTENT_TYPE'])) {
            $headers['Content-Type'] = $_SERVER['CONTENT_TYPE'];
        }

        if (isset($_SERVER['CONTENT_LENGTH'])) {
            $headers['Content-Length'] = $_SERVER['CONTENT_LENGTH'];
        }

        return $headers;
    }
}
