<?php

namespace Stella\Support\Traits\Str;

trait TrimTrait
{
    use StringTrait;

    public function trim(string $characters = " \n\r\t\v\x00"): self
    {
        return $this->with(trim($this->value(), $characters));
    }

    public function ltrim(string $characters = " \n\r\t\v\x00"): self
    {
        return $this->with(ltrim($this->value(), $characters));
    }

    public function rtrim(string $characters = " \n\r\t\v\x00"): self
    {
        return $this->with(rtrim($this->value(), $characters));
    }

    public function squish(string|array $characters = [" ", "\n", "\r", "\t", "\v", "\0"]): self
    {
        return $this->with(str_replace($characters, '', $this->value()));
    }
}
