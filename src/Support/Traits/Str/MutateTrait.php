<?php

namespace Stella\Support\Traits\Str;

trait MutateTrait {
    use StringTrait;
    
    public function replace(string|array $search, string $replace): self {
        return $this->with(str_replace($search, $replace, $this->value()));
    }

    public function remove(string|array $search): self {
        return $this->with($this->replace($search, '')->value());
    }
}
