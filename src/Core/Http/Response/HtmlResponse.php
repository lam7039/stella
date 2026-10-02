<?php

namespace Stella\Core\Http\Response;

class HtmlResponse extends Response
{
    public function __construct(
        private readonly mixed $html,
        int $statusCode = 200,
        array $headers = [],
    )
    {
        $headers['Content-Type'] ??= 'text/html; charset=UTF-8';
        parent::__construct($statusCode, $headers);
    }

    protected function getContent(): string
    {
        return $this->html;
    }
}
