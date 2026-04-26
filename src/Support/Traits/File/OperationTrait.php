<?php

namespace Stella\Support\Traits\File;

trait OperationTrait
{
    use FileTrait;

    public function copy(string $destination): self
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

        return $this->with($destination);
    }

    public function move(string $destination): self
    {
        if (! rename($this->path(), $destination)) {
            throw new \RuntimeException("Failed to move file to: {$destination}");
        }

        return $this->with($destination);
    }

    public function remove(): bool
    {
        if (! is_file($this->path())) {
            return false;
        }

        return unlink($this->path());
    }
}
