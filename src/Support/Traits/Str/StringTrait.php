<?php

namespace Stella\Support\Traits\Str;

trait StringTrait {
    abstract public function with(string $value): self;
    abstract public function value(): string;
}
