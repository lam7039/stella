<?php

namespace Stella\Support\Traits\Filesystem;

trait FilesystemTrait
{
    abstract protected function newInstanceAt(string $path): static;
    abstract public function path(): string;
}
