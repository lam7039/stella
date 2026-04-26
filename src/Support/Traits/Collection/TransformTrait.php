<?php

namespace Stella\Support\Traits\Collection;

trait TransformTrait
{
    public function map(callable $callback): self
    {
        $this->items = array_map($callback, $this->items, array_keys($this->items));
        return $this;
    }

    public function filter(callable $callback): self
    {
        $this->items = array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH);
        return $this;
    }

    public function reject(callable $callback): self
    {
        $this->items = array_filter($this->items, fn($item, $key) => ! $callback($item, $key), ARRAY_FILTER_USE_BOTH);
        return $this;
    }

    public function pluck(string $key): self
    {
        $this->items = array_map(fn($item) => $item[$key] ?? null, $this->items);
        return $this;
    }

    public function values(): self
    {
        $this->items = array_values($this->items);
        return $this;
    }
}
