<?php

namespace Stella\Support\Traits\File;

use Generator;

trait ReadTrait
{
    use FileTrait;

    public function contents(): string
    {
        if (! is_file($this->path())) {
            throw new \RuntimeException("File not found: {$this->path()}");
        }

        $contents = file_get_contents($this->path());

        if ($contents === false) {
            throw new \RuntimeException("Failed to read file: {$this->path()}");
        }

        return $contents;
    }

    public function readLines(): Generator
    {
        $file = fopen($this->path(), 'r');

        if ($file === false) {
            throw new \RuntimeException("Failed to open file: {$this->path()}");
        }

        try {
            while (($line = fgets($file)) !== false) {
                yield rtrim($line, "\r\n");
            }
        } finally {
            fclose($file);
        }
    }
}
