<?php

namespace Stella\Providers;

use Stella\Core\App;
use Stella\Core\Storage\StorageManager;

class StorageServiceProvider
{
    public function register(App $app): void
    {
        $app->singleton(StorageManager::class, function() {
            return new StorageManager(config('storage'));
        });
    }
}
