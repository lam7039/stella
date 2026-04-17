<?php

namespace Stella\Providers;

use Stella\Core\Container;
use Stella\Core\Exceptions\Handler;

class ExceptionServiceProvider
{
    public function register(Container $container): void 
    {
        $container->singleton(Handler::class);
    }

    public function boot(Container $container): void
    {
        $container->get(Handler::class)->register();
    }
}
