<?php

namespace Stella\Core\Storage;

use Stella\Core\Storage\Contracts\StorageInterface;

class StorageManager {
    private array $disks = [];

    public function __construct(private array $config) {}

    public function disk(?string $name = null): StorageInterface {
        $name ??= $this->config['default'];

        if (isset($this->disks[$name])) {
            return $this->disks[$name];
        }
        
        if (! isset($this->config['disks'][$name])) {
            throw new \InvalidArgumentException("Storage disk [{$name}] is not configured.");
        }

        return $this->disks[$name] = StorageFactory::make(
            $name,
            $this->config['disks'][$name]
        );
    }
}
