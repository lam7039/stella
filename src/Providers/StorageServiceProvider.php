<?php

namespace Stella\Providers;

use Stella\Core\Container;
use Stella\Core\Storage\StorageManager;

class StorageServiceProvider
{
    public function register(Container $container): void
    {
        $container->singleton(StorageManager::class, function() {
            return new StorageManager(config('storage'));
        });
    }
}
