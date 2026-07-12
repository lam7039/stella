<?php

namespace Stella\Core\Http\Response;

class InertiaResponse extends Response
{
    public function __construct(private readonly array $data)
    {
        parent::__construct();

        [$component, $props] = $data;

        $this->setHeader('Content-Type', 'application/json');
        $this->setBody(json_encode([
            'component' => $component,
            'props' => $props,
        ]));
    }
}
