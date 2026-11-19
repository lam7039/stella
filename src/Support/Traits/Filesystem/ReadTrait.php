<?php

namespace Stella\Support\Traits\Filesystem;

use Generator;

trait ReadTrait
{
    use FilesystemTrait;

    public function contents(): string
    {
        if (! is_file($this->path())) {
            throw new \RuntimeException(sprintf("File not found: %s", $this->path()));
        }

        $contents = file_get_contents($this->path());

        if ($contents === false) {
            throw new \RuntimeException(sprintf("Failed to read file: %s", $this->path()));
        }

        return $contents;
    }

    //TODO: read large files in chunks to avoid memory issues
    //TODO: look into headers for streaming large files
    public function readChunks(int $chunkSize = 1024 * 1024): Generator
    {
        $handle = fopen($this->path(), 'rb'); //rb is for reading in binary mode

        if ($handle === false) {
            throw new \RuntimeException(sprintf("Failed to open file: %s", $this->path()));
        }

        //TODO: video streaming support
        // fseek($handle, $offset);

        try {
            while (! feof($handle)) {
                $chunk = fread($handle, $chunkSize);

                if ($chunk === false) {
                    throw new \RuntimeException(sprintf("Failed to read chunk from file: %s", $this->path()));
                }

                yield $chunk;
            }
        } finally {
            fclose($handle);
        }
    }
}
