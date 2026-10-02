<?php

namespace Stella\Core\Http\Response;

class EmptyResponse extends Response
{
    public function __construct(
        int $statusCode = 204,
        array $headers = [],
    )
    {
        parent::__construct($statusCode, $headers);
    }

    protected function getContent(): string
    {
        return '';
    }
}
