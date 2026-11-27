<?php

namespace Stella\Core\Http;

use Stella\Core\Http\Response\HttpResponse;

final class ResponseEmitter
{
    public function emit(HttpResponse $response): void
    {
        if (headers_sent($file, $line)) {
            throw new \RuntimeException(sprintf('Headers already sent in %s on line %d.', $file, $line));
        }

        http_response_code($response->statusCode());

        foreach ($response->headers() as $name => $values) {
            foreach ((array) $values as $value) {
                header(sprintf("%s: %s", $name, $value), false);
            }
        }

        if ($response->body() !== '') {
            echo $response->body();
        }
    }
}
