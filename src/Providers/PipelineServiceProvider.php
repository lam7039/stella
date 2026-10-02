<?php

namespace Stella\Providers;

use Stella\Core\Container;
use Stella\Core\Pipeline;

class PipelineServiceProvider implements ServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(Pipeline::class, function (Container $container) {
            return new Pipeline($container);
        });
    }

    public function boot(Container $container): void
    {
        //
    }
}
