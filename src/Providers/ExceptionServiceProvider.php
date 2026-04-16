<?php

namespace Stella\Providers;

use Stella\Core\App;
use Stella\Core\Exceptions\Handler;

class ExceptionServiceProvider
{
    public function register(App $app): void 
    {
        $app->singleton(Handler::class);
    }

    public function boot(App $app): void
    {
        $app->get(Handler::class)->register();
    }
}
