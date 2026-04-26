<?php

namespace Stella\Support\Traits\Collection;

trait SortTrait
{
    public function sort(callable $callback): self
    {
        usort($this->items, $callback);
        return $this;
    }

    public function reverse(): self
    {
        $this->items = array_reverse($this->items);
        return $this;
    }

    public function keys(): array
    {
        return array_keys($this->items);
    }
}
