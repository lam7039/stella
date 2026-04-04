<?php

namespace Stella\Support;

use Stella\Support\Traits\File\FileTrait;
use Stella\Support\Traits\File\DirectoryTrait;
use Stella\Support\Traits\File\AccessTrait;
use Stella\Support\Traits\File\ReadTrait;
use Stella\Support\Traits\File\WriteTrait;
use Stella\Support\Traits\File\OperationTrait;

class File {
    use FileTrait;
    use DirectoryTrait;
    use AccessTrait;
    use ReadTrait;
    use WriteTrait;
    use OperationTrait;

    public function __construct(private readonly string $path) {}

    public static function of(string $path): self {
        return new self($path);
    }

    public function with(string $path): self {
        return self::of($path);
    }

    public function path(): string {
        return $this->path;
    }

    public function __toString(): string {
        return $this->path();
    }
}
