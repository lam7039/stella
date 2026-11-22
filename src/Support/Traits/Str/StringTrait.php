<?php

namespace Stella\Support\Traits\Str;

trait StringTrait
{
    abstract protected function newInstanceOf(string $value): static;
    abstract public function value(): string;
}
