<?php

namespace Stella\Support;

use Generator;

class File {
    public function __construct(private readonly string $path) {}

    public function path(): string {
        return $this->path;
    }

    public function exists(): bool {
        return is_file($this->path);
    }

    public function size(): int {
        return filesize($this->path);
    }

    public function contents(): string {
        if (! $this->exists()) {
            throw new \RuntimeException("File not found: {$this->path}");
        }

        return file_get_contents($this->path);
    }

    public function readLines(): Generator {
        $file = fopen($this->path, 'r');

        if (false === $file) {
            throw new \RuntimeException("Failed to open file: {$this->path}");
        }

        while (false !== ($line = fgets($file))) {
            yield rtrim($line, "\r\n");
        }

        fclose($file);
    }

    public function write(string $content): self {
        if (! is_dir(dirname($this->path))) {
            mkdir(dirname($this->path), 0755, true);
        }

        file_put_contents($this->path, $content, LOCK_EX);
        return $this;
    }

    public function append(string $content): self {
        file_put_contents($this->path, $content, FILE_APPEND | LOCK_EX);
        return $this;
    }

    public function streamWrite(iterable $chunks): self {
        $file = fopen($this->path, 'wb');

        if (false === $file) {
            throw new \RuntimeException("Failed to open file: {$this->path}");
        }

        flock($file, LOCK_EX);

        foreach ($chunks as $chunk) {
            fwrite($file, $chunk);
        }
        
        fflush($file);
        flock($file, LOCK_UN);

        fclose($file);

        return $this;
    }

    public function move(string $destination): bool {
        return rename($this->path, $destination);
    }

    public function touch(): self {
        touch($this->path);
        return $this;
    }

    public function lastModified(): int {
        return filemtime($this->path);
    }

    public function hash(string $algo = 'sha256'): string {
        return hash_file($algo, $this->path);
    }

    public function chmod(int $permissions): self {
        chmod($this->path, $permissions);
        return $this;
    }
}
