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
        parent::__construct($statusCode, $headers);
        $this->setHeader('Content-Type', 'application/json');
    }

    protected function getContent(): string
    {
        return json_encode($this->data, JSON_THROW_ON_ERROR);
    }
}
