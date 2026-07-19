<?php

namespace Stella\Core\Http\Response;

use Stella\Core\Http\Request\Request;

//TODO: forget about inertia, create a custom 'glue' between Stella and the front-end framework (Vue, React, etc.) call it Comet, the fallback templating engine can be called Nova. It's a play on words, Stella is a star, Nova is an expansion of a star , Comet is a meteor. The idea is that Stella is the framework, Comet is the front-end framework adapter, and Nova is the fallback templating engine for when you don't want to use a front-end framework.
class CometResponse extends Response
{
    public function __construct(
        protected Request $request,
        protected string $component,
        protected array $props = [],
        int $statusCode = 200
    )
    {
        parent::__construct($statusCode);
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
            $this
                ->withHeader('Content-Type', 'application/json')
                ->withHeader('X-Comet', 'true');

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
