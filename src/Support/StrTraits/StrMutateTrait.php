<?php

namespace Stella\Support\StrTraits;

trait StrMutateTrait {
    public function replace(string|array $search, string $replace): self {
        return $this->new(str_replace($search, $replace, $this->value));
    }

    public function remove(string|array $search): self {
        return $this->new($this->replace($search, '')->value());
    }
}
