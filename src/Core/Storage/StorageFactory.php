<?php

namespace Stella\Core\Storage;

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Stella\Core\Storage\Contracts\StorageInterface;
use Stella\Core\Storage\Adapters\FlysystemStorage;

class StorageFactory
{
    public static function make(string $driver, array $config): StorageInterface
    {
        return match ($driver) {
            'local' => new FlysystemStorage(
                new Filesystem(
                    new LocalFilesystemAdapter($config['root'])
                )
            ),
            default => throw new \InvalidArgumentException("Unsupported storage driver: {$driver}"),
        };
    }
}
