<?php

namespace Stella\Support;

use Stella\Support\StrTraits\StrCaseTrait;
use Stella\Support\StrTraits\StrTrimTrait;
use Stella\Support\StrTraits\StrSearchTrait;

class Str {
    use StrCaseTrait;
    use StrTrimTrait;
    use StrSearchTrait;

    private function __construct(private string $value) {}

    public static function of(string $value): self {
        return new self($value);
    }

    public function value(): string {
        return $this->value;
    }
}
