<?php

namespace Stella\Core\Http\Response;

class HttpResponse extends Response
{
    public function __construct(
        private readonly mixed $data,
        int $statusCode = 200,
        array $headers = []
    )
    {
        parent::__construct($statusCode, $headers);
    }

    protected function getContent(): string
    {
        return $this->data;
    }
}
