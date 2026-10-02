<?php

namespace Stella\Providers;

use Stella\Core\Container;

interface ServiceProvider
{
    public function register(Container $container): void;

    public function boot(Container $container): void;
}
