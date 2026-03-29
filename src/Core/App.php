<?php

namespace Stella\Core;

class App extends Container {
    private static ?self $instance = null;
    private array $providers = [];

    public static function instance(): self {
        return self::$instance ?? throw new \RuntimeException("App not initialized");
    }

    public function __construct() {
        self::$instance = $this;
    }

    public function register(string $providerClass): void {
        $provider = new $providerClass();

        if (! method_exists($provider, 'register')) {
            throw new \RuntimeException("Service provider must have a register method: {$providerClass}");
        }

        $provider->register($this);
        $this->providers[] = $provider;
    }

    public function boot(): void {
        foreach ($this->providers as $provider) {
            if (method_exists($provider, 'boot')) {
                $provider->boot($this);
            }
        }
    }
}
