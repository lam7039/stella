<?php

namespace Stella\Core\Http\Response;

class JsonResponse extends Response
{
    public function __construct(
        private readonly mixed $data,
        int $statusCode = 200,
        array $headers = []
    )
    {
        $headers['Content-Type'] = 'application/json';
        parent::__construct($statusCode, $headers);
    }

    protected function getContent(): string
    {
        return json_encode($this->data, JSON_THROW_ON_ERROR);
    }
}
