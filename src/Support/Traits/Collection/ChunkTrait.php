<?php

namespace Stella\Support\Traits\Collection;

trait ChunkTrait {
    public function chunk(int $size): array {
        return array_chunk($this->items, $size);
    }
}
