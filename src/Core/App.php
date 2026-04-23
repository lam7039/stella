<?php

namespace Stella\Core;

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
}
