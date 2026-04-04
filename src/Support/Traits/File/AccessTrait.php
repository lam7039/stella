<?php

namespace Stella\Support\Traits\File;

trait AccessTrait {
    use FileTrait;

    public function size(): int {
        return filesize($this->path());
    }

    public function exists(): bool {
        return is_file($this->path());
    }

    public function lastModified(): int {
        if (! $this->exists()) {
            throw new \RuntimeException("File not found: {$this->path()}");
        }

        return filemtime($this->path());
    }

    public function hash(string $algorithm = 'sha256'): string {
        if (! $this->exists()) {
            throw new \RuntimeException("File not found: {$this->path()}");
        }

        return hash_file($algorithm, $this->path()); 
    }
}
