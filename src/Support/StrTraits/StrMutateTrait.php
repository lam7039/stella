<?php

namespace Stella\Support\StrTraits;

trait StrMutateTrait {
    public function replace(string|array $search, string $replace): self {
        return new self(str_replace($search, $replace, $this->value));
    }

    public function remove(string|array $search): self {
        return new self($this->replace($search, '')->value());
    }
}
