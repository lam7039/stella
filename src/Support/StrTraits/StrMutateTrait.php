<?php

namespace Stella\Support\StrTraits;

trait StrMutateTrait {
    public function replace(string|array $search, string $replace): static {
        return $this->new(str_replace($search, $replace, $this->value));
    }

    public function remove(string|array $search): static {
        return $this->new($this->replace($search, '')->value());
    }
}
