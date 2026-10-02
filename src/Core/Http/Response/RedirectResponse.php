<?php

namespace Stella\Core\Http\Response;

class RedirectResponse extends Response
{
    public function __construct(
        private readonly string $url,
        int $statusCode = 302,
        array $headers = []
    )
    {
        $headers['Location'] = $url;
        parent::__construct($statusCode, $headers);
    }
}
