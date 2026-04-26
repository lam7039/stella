<?php

namespace Stella\Support\Traits\File;

trait FileTrait
{
    abstract public function with(string $path): self;
    abstract public function path(): string;
}
