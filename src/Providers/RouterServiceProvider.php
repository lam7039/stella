<?php

namespace Stella\Providers;

use Stella\Core\Container;
use Stella\Core\Routing\Router;

class RouterServiceProvider
{
    public function register(Container $container): void
    {
        $container->singleton(Router::class, function (Container $container) {
            return new Router($container);
        });
    }

    public function boot(Container $container): void
    {
        require base_path('routes/web.php');
    }
}
