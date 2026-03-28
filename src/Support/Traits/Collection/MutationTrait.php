<?php

namespace Stella\Support\Traits\Collection;

trait MutationTrait {
    public function append(mixed $item): self {
        $this->items[] = $item;
        return $this;
    }

    public function prepend(mixed $item): self {
        array_unshift($this->items, $item);
        return $this;
    }

    public function merge(array|self $items): self {
        $this->items = array_merge($this->items, $items instanceof self ? $items->toArray() : $items);
        return $this;
    }

    public function unique(): self {
        $this->items = array_unique($this->items);
        return $this;
    }
}
