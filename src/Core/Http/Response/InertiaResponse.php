<?php

namespace Stella\Core\Http\Response;

use Stella\Core\Http\Request\Request;

class InertiaResponse extends Response
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

        if ($this->request->header('X-Inertia')) {
            $this->setHeader('Content-Type', 'application/json');
            $this->setHeader('X-Inertia', 'true');

            return json_encode($page, JSON_THROW_ON_ERROR);
        }

        return '';

        //TODO: use custom templating engine to render the view as a fallback
        // return view('app', [
        //     'page' => json_encode($page, JSON_THROW_ON_ERROR),
        // ]);
    }
}
