<?php

namespace Stella\Core\Http\Response;

class TextResponse extends Response
{
    public function __construct(
        private readonly mixed $text,
        int $statusCode = 200,
        array $headers = [],
    )
    {
        $headers['Content-Type'] ??= 'text/plain; charset=UTF-8';
        parent::__construct($statusCode, $headers);
    }

    protected function getContent(): string
    {
        return $this->text;
    }
}
