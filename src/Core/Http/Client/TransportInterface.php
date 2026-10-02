<?php

namespace Stella\Core\Http\Client;

use Stella\Core\Http\Response\Response;

interface TransportInterface
{
    public function send(
        string $method,
        string $url,
        array $options = []
    ): Response;
}
