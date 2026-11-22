<?php

namespace Stella\Support\Traits\Str;

trait CaseTrait
{
    use StringTrait;

    public function upper(): static
    {
        return $this->newInstanceOf(mb_strtoupper($this->value()));
    }

    public function lower(): static
    {
        return $this->newInstanceOf(mb_strtolower($this->value()));
    }

    public function capitalize(): static
    {
        return $this->newInstanceOf(mb_ucfirst($this->value()));
    }

    public function title(): static
    {
        return $this->newInstanceOf(mb_convert_case($this->value(), MB_CASE_TITLE));
    }
}
