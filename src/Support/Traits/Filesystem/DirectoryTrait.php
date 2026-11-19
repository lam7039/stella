<?php

namespace Stella\Support\Traits\Filesystem;

trait DirectoryTrait
{
    public static function createDirectory(string $path, int $permissions = 0755): void
    {
        if (is_file($path)) {
            throw new \RuntimeException("Path includes a file: {$path}");
        }

        if (
            ! is_dir($path) &&
            ! mkdir($path, $permissions, true) &&
            ! is_dir($path)
        ) {
            throw new \RuntimeException("Failed to create directory: {$path}");
        }
    }

    public static function isDirectoryEmpty(string $path): bool
    {
        if (! is_dir($path)) {
            throw new \RuntimeException("Not a directory: {$path}");
        }

        return ! new \FilesystemIterator($path)->valid();
    }

    public static function removeDirectory(string $path): bool
    {
        if (! is_dir($path)) {
            throw new \RuntimeException("Not a directory: {$path}");
        }

        return rmdir($path);
    }
}
