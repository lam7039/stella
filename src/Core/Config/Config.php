<?php

namespace Stella\Core\Config;

class Config
{
    private array $items = [];

    public function load(array $config): void
    {
        $this->items = $config;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $keys = explode('.', $key);
        $value = $this->items;

        foreach ($keys as $k) {
            if (! isset($value[$k])) {
                return $default;
            }

            $value = $value[$k];
        }

        return $value;
    }
    
    public function has(string $key): bool
    {
        $keys = explode('.', $key);
        $value = $this->items;

        foreach ($keys as $k) {
            if (! isset($value[$k])) {
                return false;
            }

            $value = $value[$k];
        }

        return true;
    }
}
