<?php

namespace Stella\Providers;

use Stella\Core\Logger;
use Stella\Core\App;

class LoggerServiceProvider
{
    public function register(App $app): void
    {
        $app->bind(Logger::class, fn () => Logger::initialize());
    }

    public function boot(App $app): void {
        // dd('Booting logger service provider');
    }
}
