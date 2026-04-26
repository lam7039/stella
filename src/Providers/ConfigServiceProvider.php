<?php

namespace Stella\Providers;

use Stella\Core\Container;
use Stella\Core\Config\Config;
use Stella\Core\Config\DotEnv;

class ConfigServiceProvider
{
    public function register(Container $container): void
    {
        $container->singleton(DotEnv::class);
        $container->singleton(Config::class);
    }

    public function boot(Container $container): void
    {
        $container->get(DotEnv::class)->load();

        $config = [];

        $files = glob(config_path('*.php'));
        sort($files);

        foreach ($files as $file) {
            $name = basename($file, '.php');
            $config[$name] = require $file;
        }

        $container->get(Config::class)->load($config);
    }
}
