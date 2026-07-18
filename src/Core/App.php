<?php

namespace Stella\Core;

use Stella\Core\Http\Request\Request;
use Stella\Core\Http\Response\Response;
use Stella\Core\Routing\Router;

class App extends Container
{
    private static ?self $instance = null;
    private array $serviceProviders = [];

    public static function instance(): self
    {
        return self::$instance ?? throw new \RuntimeException("App not initialized");
    }

    public function __construct()
    {
        self::$instance = $this;
    }

    public function register(string $serviceProviderClass): void
    {
        $serviceProvider = new $serviceProviderClass();

        if (! method_exists($serviceProvider, 'register')) {
            throw new \RuntimeException("Service provider must have a register method: {$serviceProviderClass}");
        }

        $serviceProvider->register($this);
        $this->serviceProviders[] = $serviceProvider;
    }

    public function boot(): void
    {
        foreach ($this->serviceProviders as $serviceProvider) {
            if (method_exists($serviceProvider, 'boot')) {
                $serviceProvider->boot($this);
            }
        }
    }

    public function run(): Response
    {
        $request = Request::capture();

        $router = $this->get(Router::class);

        $route = $router->match($request);

        return $route->run($request);
    }
}
