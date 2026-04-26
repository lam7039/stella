<?php

namespace Stella\Support;

use Stella\Support\Traits\Collection\{
    ConvertTrait,
    AccessTrait,
    MutationTrait,
    TransformTrait,
    SortTrait,
    ChunkTrait,
};

class Collection implements \Countable, \IteratorAggregate
{
    use ConvertTrait;
    use AccessTrait;
    use MutationTrait;
    use TransformTrait;
    use SortTrait;
    use ChunkTrait;

    public function __construct(private array $items = []) {}

    public function count(): int
    {
        return count($this->items);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }
}
