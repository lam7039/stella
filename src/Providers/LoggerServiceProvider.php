<?php

namespace Stella\Providers;

use Stella\Core\Container;
use Stella\Core\Logging\Logger;

class LoggerServiceProvider
{
    public function register(Container $container): void
    {
        $container->singleton(Logger::class);
    }

    public function boot(Container $container): void
    {
        $container->get(Logger::class)->reset();
    }
}
