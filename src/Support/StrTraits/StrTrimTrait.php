<?php

namespace Stella\Support\StrTraits;

trait StrTrimTrait {
    public function trim(string $characters = " \n\r\t\v\x00"): self {
        return $this->new(trim($this->value, $characters));
    }

    public function ltrim(string $characters = " \n\r\t\v\x00"): self {
        return $this->new(ltrim($this->value, $characters));
    }

    public function rtrim(string $characters = " \n\r\t\v\x00"): self {
        return $this->new(rtrim($this->value, $characters));
    }

    public function squish(string|array $characters = [" ", "\n", "\r", "\t", "\v", "\0"]): self {
        return $this->new(str_replace($characters, '', $this->value));
    }
}
