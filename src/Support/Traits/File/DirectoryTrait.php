<?php

namespace Stella\Support\Traits\File;

trait DirectoryTrait
{
    public static function mkdir(string $path, int $permissions = 0755): void
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

    public static function isEmpty(string $path): bool
    {
        if (! is_dir($path)) {
            throw new \RuntimeException("Not a directory: {$path}");
        }

        return count(scandir($path)) <= 2; // only . and ..
    }

    public static function removeDirectory(string $path): bool
    {
        if (! is_dir($path)) {
            throw new \RuntimeException("Not a directory: {$path}");
        }

        return rmdir($path);
    }
}
