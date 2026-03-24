<?php

namespace Stella\Support\StrTraits;

trait StrTrimTrait {
    public function trim(): self {
        return new self(trim($this->value));
    }

    public function ltrim(): self {
        return new self(ltrim($this->value));
    }

    public function rtrim(): self {
        return new self(rtrim($this->value));
    }

    public function squish(): self {
        return new self(str_replace(' ', '', $this->value));
    }
}
