<?php

namespace Stella\Support\Traits\File;

trait WriteTrait
{
    use FileTrait;

    public function write(string $content): self
    {
        self::mkdir(dirname($this->path()));

        if (! file_put_contents($this->path(), $content, LOCK_EX)) {
            throw new \RuntimeException("Failed to write to file: {$this->path()}");
        }

        return $this;
    }

    public function append(string $content): self
    {
        if (! file_put_contents($this->path(), $content, FILE_APPEND | LOCK_EX)) {
            throw new \RuntimeException("Failed to append to file: {$this->path()}");
        }

        return $this->with($this->path());
    }

    public function streamWrite(iterable $chunks): self
    {
        $file = fopen($this->path(), 'wb');

        if ($file === false) {
            throw new \RuntimeException("Failed to open file: {$this->path()}");
        }

        flock($file, LOCK_EX);

        foreach ($chunks as $chunk) {
            fwrite($file, $chunk);
        }

        fflush($file);
        flock($file, LOCK_UN);

        fclose($file);

        return $this->with($this->path());
    }

    public function touch(): self
    {
        if (! touch($this->path())) {
            throw new \RuntimeException("Failed to touch file: {$this->path()}");
        }

        return $this->with($this->path());
    }

    public function chmod(int $permissions): self
    {
        if (! chmod($this->path(), $permissions)) {
            throw new \RuntimeException("Failed to change permissions for: {$this->path()}");
        }

        return $this->with($this->path());
    }
}
