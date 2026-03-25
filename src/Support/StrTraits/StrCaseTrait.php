<?php

namespace Stella\Support\StrTraits;

trait StrCaseTrait {
    public function upper(): self {
        return $this->with(mb_strtoupper($this->value()));
    }

    public function lower(): self {
        return $this->with(mb_strtolower($this->value()));
    }

    public function capitalize(): self {
        return $this->with(mb_ucfirst($this->value()));
    }

    public function title(): self {
        return $this->with(mb_convert_case($this->value(), MB_CASE_TITLE));
    }
}
