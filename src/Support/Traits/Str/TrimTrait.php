<?php

namespace Stella\Support\Traits\Str;

trait TrimTrait
{
    use StringTrait;

    public function trim(string $characters = " \n\r\t\v\x00"): static
    {
        return $this->newInstanceOf(trim($this->value(), $characters));
    }

    public function ltrim(string $characters = " \n\r\t\v\x00"): static
    {
        return $this->newInstanceOf(ltrim($this->value(), $characters));
    }

    public function rtrim(string $characters = " \n\r\t\v\x00"): static
    {
        return $this->newInstanceOf(rtrim($this->value(), $characters));
    }

    //TODO: this squishes "  Hello     World   " to "HelloWorld" instead of "Hello World", is this intended?
    public function squish(string|array $characters = [" ", "\n", "\r", "\t", "\v", "\0"]): static
    {
        return $this->newInstanceOf(str_replace($characters, '', $this->value()));
    }
}
