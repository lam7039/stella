<?php

namespace Stella\Core\Routing;

use Stella\Core\Http\Request\Request;
use Stella\Core\Http\Request\RequestMethod;

class Router
{
    protected array $routes = [];

    public function get(string $uri, mixed $handler): Route
    {
        return $this->addRoute(RequestMethod::GET, $uri, $handler);
    }

    public function post(string $uri, mixed $handler): Route
    {
        return $this->addRoute(RequestMethod::POST, $uri, $handler);
    }

    public function put(string $uri, mixed $handler): Route
    {
        return $this->addRoute(RequestMethod::PUT, $uri, $handler);
    }

    public function delete(string $uri, mixed $handler): Route
    {
        return $this->addRoute(RequestMethod::DELETE, $uri, $handler);
    }

    protected function addRoute(RequestMethod $method, string $uri, mixed $handler): Route
    {
        $route = new Route($method, $uri, $handler);

        $this->routes[] = $route;

        return $route;
    }

    public function match(Request $request): Route
    {
        foreach ($this->routes as $route) {
            if (
                $route->method === $request->method() &&
                $route->uri === $request->uri()
            ) {
                return $route;
            }
        }

        throw new \RuntimeException('No matching route found for ' . $request->method() . ' ' . $request->uri());
    }
}
