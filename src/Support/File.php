<?php

namespace Stella\Support;

use Stella\Support\Traits\File\{
    FileTrait,
    DirectoryTrait,
    AccessTrait,
    ReadTrait,
    WriteTrait,
    OperationTrait,
};

class File
{
    use FileTrait;
    use DirectoryTrait;
    use AccessTrait;
    use ReadTrait;
    use WriteTrait;
    use OperationTrait;

    public function __construct(private readonly string $path) {}

    public static function of(string $path): self
    {
        return new self($path);
    }

    public function with(string $path): self
    {
        return self::of($path);
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
