<?php

namespace Stella\Support\Traits\Str;

trait MutateTrait
{
    use StringTrait;

    public function replace(string|array $search, string $replace): static
    {
        return $this->newInstanceOf(str_replace($search, $replace, $this->value()));
    }

    public function remove(string|array $search): static
    {
        return $this->newInstanceOf($this->replace($search, '')->value());
    }

    public function prepend(string $value): static
    {
        return $this->newInstanceOf($value . $this->value());
    }

    public function append(string $value): static
    {
        return $this->newInstanceOf($this->value() . $value);
    }
}
