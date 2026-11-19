<?php

namespace Stella\Support\Traits\Filesystem;

trait OperationTrait
{
    use FilesystemTrait;

    public function copy(string $destination): static
    {
        if (! is_file($this->path())) {
            throw new \RuntimeException("File not found: {$this->path()}");
        }

        if (! is_dir(dirname($destination))) {
            throw new \RuntimeException("Destination directory does not exist: {$destination}");
        }

        if (! copy($this->path(), $destination)) {
            throw new \RuntimeException("Failed to copy file to: {$destination}");
        }

        return $this->newInstanceAt($destination);
    }

    public function move(string $destination): static
    {
        if (! rename($this->path(), $destination)) {
            throw new \RuntimeException("Failed to move file to: {$destination}");
        }

        return $this->newInstanceAt($destination);
    }

    public function remove(): bool
    {
        if (! is_file($this->path())) {
            return false;
        }

        return unlink($this->path());
    }
}
