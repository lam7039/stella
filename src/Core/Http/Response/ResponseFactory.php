<?php

namespace Stella\Core\Http\Response;

final class ResponseFactory
{
    public function http(int $statusCode = 204, array $headers = []): HttpResponse
    {
        return new HttpResponse($statusCode, $headers);
    }

    public function json(mixed $data, int $statusCode = 200, array $headers = []): JsonResponse
    {
        return new JsonResponse($data, $statusCode, $headers);
    }

    public function redirect(string $url, int $statusCode = 302, array $headers = []): RedirectResponse
    {
        return new RedirectResponse($url, $statusCode, $headers);
    }

    public function html(string $html, int $statusCode = 200, array $headers = []): HtmlResponse
    {
        return new HtmlResponse($html, $statusCode, $headers);
    }
}
