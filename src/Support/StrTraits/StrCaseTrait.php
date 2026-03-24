<?php

namespace Stella\Support\StrTraits;

trait StrCaseTrait {
    public function upper(): self {
        return new self(mb_strtoupper($this->value));
    }

    public function lower(): self {
        return new self(mb_strtolower($this->value));
    }

    public function capitalize(): self {
        return new self(mb_ucfirst($this->value));
    }

    public function title(): self {
        return new self(mb_convert_case($this->value, MB_CASE_TITLE));
    }
}
