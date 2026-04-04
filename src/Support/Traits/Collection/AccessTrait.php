<?php

namespace Stella\Support\Traits\Collection;

trait AccessTrait {
    public function get(int|string $key, mixed $default = null): mixed {
        return $this->items[$key] ?? $default;
    }

    public function first(): mixed {
        return reset($this->items) ?: null; //TODO: php 8.5 introduces `array_first` function that can be used here
    }

    public function last(): mixed {
        return end($this->items) ?: null; //TODO: php 8.5 introduces `array_last` function that can be used here
    }

    public function contains(mixed $item): bool {
        return in_array($item, $this->items, true);
    }

    public function search(callable $callback): ?int {
        foreach ($this->items as $key => $value) {
            if ($callback($value, $key)) {
                return $key;
            }
        }
        return null;
    }

    public function has(int|string $key): bool {
        return array_key_exists($key, $this->items);
    }
}
