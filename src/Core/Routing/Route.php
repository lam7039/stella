<?php

namespace Stella\Core\Routing;

use Stella\Core\Http\Request\Request;
use Stella\Core\Http\Request\RequestMethod;
use Stella\Core\Http\Response\Response;

class Route
{
    public function __construct(
        public readonly RequestMethod $method,
        public readonly string $uri,
        public readonly mixed $handler,
        protected array $middleware = []
    ) {
    }

    public function middleware(string|array $middleware): static
    {
        if (is_string($middleware)) {
            $middleware = [$middleware];
        }

        $this->middleware = array_merge($this->middleware, $middleware);

        return $this;
    }

    public function run(Request $request): Response
    {
        if (is_callable($this->handler)) {
            return call_user_func($this->handler, $request);
        }

        [$controller, $method] = $this->handler;

        return new $controller()->{$method}($request);
    }

    //TODO: middleware
    //TODO: groups like web, api
}
