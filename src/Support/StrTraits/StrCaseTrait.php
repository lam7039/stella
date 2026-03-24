<?php

namespace Stella\Support\StrTraits;

trait StrCaseTrait {
    public function upper(): static {
        return $this->new(mb_strtoupper($this->value));
    }

    public function lower(): static {
        return $this->new(mb_strtolower($this->value));
    }

    public function capitalize(): static {
        return $this->new(mb_ucfirst($this->value));
    }

    public function title(): static {
        return $this->new(mb_convert_case($this->value, MB_CASE_TITLE));
    }
}
