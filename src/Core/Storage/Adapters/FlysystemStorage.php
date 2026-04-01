<?php

namespace Stella\Core\Storage\Adapters;

use League\Flysystem\Filesystem;
use Stella\Core\Storage\Contracts\StorageInterface;

class FlysystemStorage implements StorageInterface
{
    public function __construct(
        protected Filesystem $filesystem
    ) {}

    public function put(string $path, string $contents): bool
    {
        $this->filesystem->write($path, $contents);
        return true;
    }

    public function get(string $path): ?string
    {
        return $this->filesystem->read($path);
    }

    public function delete(string $path): bool
    {
        $this->filesystem->delete($path);
        return true;
    }

    public function exists(string $path): bool
    {
        return $this->filesystem->fileExists($path);
    }

    public function move(string $from, string $to): bool
    {
        $this->filesystem->move($from, $to);
        return true;
    }
}
