<?php

namespace Stella\Core\Http\Response;

use Stella\Core\Http\Request\Request;

class CometResponse extends Response
{
    public function __construct(
        protected Request $request,
        protected string $component,
        protected array $props = [],
        int $statusCode = 200
    )
    {
        $headers = [];

        if ($this->request->header('X-Comet')) {
            $headers['Content-Type'] = 'application/json';
            $headers['X-Comet'] = 'true';
        }

        parent::__construct($statusCode, $headers);
    }

    protected function getContent(): string
    {
        $page = [
            'component' => $this->component,
            'props'     => $this->props,
            'url'       => $this->request->uri(),
            'version'   => config('app.version'), //TODO: versioning for assets and learn what this is for
        ];

        if ($this->request->header('X-Comet')) {
            return json_encode($page, JSON_THROW_ON_ERROR);
        }

        return new NovaResponse(
            $this->request,
            $this->component,
            $this->props,
            $this->statusCode()
        )->content();
    }
}
