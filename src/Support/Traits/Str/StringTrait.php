<?php

namespace Stella\Support\Traits\Str;

trait StringTrait
{
    abstract public function newInstanceOf(string $value): static;
    abstract public function value(): string;
}
