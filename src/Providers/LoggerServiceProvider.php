<?php

namespace Stella\Providers;

use Stella\Core\App;
use Stella\Core\Logging\Logger;

class LoggerServiceProvider {
    public function register(App $app): void {
        $app->singleton(Logger::class, Logger::class);
    }

    public function boot(App $app): void {
        $app->get(Logger::class)->reset();
    }
}
