<?php

namespace Stella\Core\Http\Response;

final class ResponseEmitter
{
    public function emit(HttpResponse $response): void
    {
        http_response_code($response->statusCode());

        foreach ($response->headers() as $name => $value) {
            header("$name: $value");
        }

        echo $response->body();
    }
}

//TODO: put ResponseEmitter directly under the Http namespace?
