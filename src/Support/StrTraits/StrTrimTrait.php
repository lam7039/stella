<?php

namespace Stella\Support\StrTraits;

trait StrTrimTrait {
    public function trim(string $characters = " \n\r\t\v\x00"): self {
        return new self(trim($this->value, $characters));
    }

    public function ltrim(string $characters = " \n\r\t\v\x00"): self {
        return new self(ltrim($this->value, $characters));
    }

    public function rtrim(string $characters = " \n\r\t\v\x00"): self {
        return new self(rtrim($this->value, $characters));
    }

    public function squish(string|array $characters = [" ", "\n", "\r", "\t", "\v", "\0"]): self {
        return new self(str_replace($characters, '', $this->value));
    }
}
