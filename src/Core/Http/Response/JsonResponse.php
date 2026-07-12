<?php

namespace Stella\Core\Http\Response;

class JsonResponse extends Response
{
    public function __construct(private readonly array $data)
    {
        parent::__construct();

        $this->setHeader('Content-Type', 'application/json');
        $this->setBody(json_encode($data));
    }
}
