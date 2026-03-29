<?php

namespace Stella\Providers;

use Stella\Core\Logger;
use Stella\Core\App;

class LoggerServiceProvider
{
    public function register(App $app): void
    {
        $app->bind(Logger::class, Logger::class);
    }

    public function boot(App $app): void {
        $app->get(Logger::class)->reset();
        // dd('Booting logger service provider');
    }
}
