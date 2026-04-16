<?php

namespace Stella\Providers;

use Stella\Core\App;
use Stella\Core\Config\Config;
use Stella\Core\Config\DotEnv;

class ConfigServiceProvider
{
    public function register(App $app): void 
    {
        $app->singleton(DotEnv::class);
        $app->singleton(Config::class);
    }

    public function boot(App $app): void
    {
        $app->get(DotEnv::class)->load();

        $config = [];

        $files = glob(config_path('*.php'));
        sort($files);

        foreach ($files as $file) {
            $name = basename($file, '.php');
            $config[$name] = require $file;
        }

        $app->get(Config::class)->load($config);
    }
}
