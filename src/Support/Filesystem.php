<?php

namespace Stella\Support;

use Stella\Support\Traits\Filesystem\{
    FilesystemTrait,
    DirectoryTrait,
    AccessTrait,
    ReadTrait,
    WriteTrait,
    OperationTrait,
};

class Filesystem
{
    use FilesystemTrait;
    use DirectoryTrait;
    use AccessTrait;
    use ReadTrait;
    use WriteTrait;
    use OperationTrait;

    public function __construct(private readonly string $path) {}

    public static function at(string $path): static
    {
        return new static($path);
    }

    protected function newInstanceAt(string $path): static
    {
        return static::at($path);
    }

    public function path(): string
    {
        return $this->path;
    }

    public function __toString(): string
    {
        return $this->path();
    }
}
