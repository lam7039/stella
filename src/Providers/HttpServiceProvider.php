<?php

namespace Stella\Providers;

use Stella\Core\Container;
use Stella\Core\Http\Session;

class HttpServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(Session::class);
    }

    public function boot(Container $container): void
    {
        $container->get(Session::class)->start();
    }
}
