<?php

namespace Stella\Support\Traits\Filesystem;

trait WriteTrait
{
    use FilesystemTrait;
    use DirectoryTrait;

    public function write(string $content): static
    {
        static::createDirectory(dirname($this->path()));

        if (file_put_contents($this->path(), $content, LOCK_EX) === false) {
            throw new \RuntimeException("Failed to write to file: {$this->path()}");
        }

        return $this;
    }

    public function append(string $content): static
    {
        if (file_put_contents($this->path(), $content, FILE_APPEND | LOCK_EX) === false) {
            throw new \RuntimeException("Failed to append to file: {$this->path()}");
        }

        return $this;
    }

    public function streamWrite(iterable $chunks): static
    {
        static::createDirectory(dirname($this->path()));

        $file = fopen($this->path(), 'c+b');

        if ($file === false) {
            throw new \RuntimeException("Failed to open file: {$this->path()}");
        }

        try {
            if (! flock($file, LOCK_EX)) {
                throw new \RuntimeException("Failed to lock file: {$this->path()}");
            }

            if (! ftruncate($file, 0)) {
                throw new \RuntimeException("Failed to truncate file: {$this->path()}");
            }

            rewind($file);

            foreach ($chunks as $chunk) {
                $chunk = (string) $chunk;
                $length = strlen($chunk);
                $written = 0;

                while ($written < $length) {
                    $result = fwrite($file, substr($chunk, $written));

                    if ($result === false || $result === 0) {
                        throw new \RuntimeException("Failed to write to file: {$this->path()}");
                    }

                    $written += $result;
                }
            }

            if (! fflush($file)) {
                throw new \RuntimeException("Failed to flush file: {$this->path()}");
            }
        } finally {
            flock($file, LOCK_UN);
            fclose($file);
        }

        return $this;
    }

    public function touch(): static
    {
        if (! touch($this->path())) {
            throw new \RuntimeException("Failed to touch file: {$this->path()}");
        }

        return $this;
    }

    public function chmod(int $permissions): static
    {
        if (! chmod($this->path(), $permissions)) {
            throw new \RuntimeException("Failed to change permissions for: {$this->path()}");
        }

        return $this;
    }
}
