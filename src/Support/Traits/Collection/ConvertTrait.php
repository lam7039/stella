<?php

namespace Stella\Support\Traits\Collection;

trait ConvertTrait
{
    public function toArray(): array
    {
        return $this->items;
    }

    public function toJson(): string
    {
        return json_encode($this->items);
    }
}
