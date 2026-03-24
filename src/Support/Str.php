<?php

namespace Stella\Support;

use Stella\Support\StrTraits\StrCaseTrait;
use Stella\Support\StrTraits\StrTrimTrait;
use Stella\Support\StrTraits\StrSearchTrait;
use Stella\Support\StrTraits\StrCastTrait;

class Str {
    use StrCaseTrait;
    use StrTrimTrait;
    use StrSearchTrait;
    use StrCastTrait;

    private function __construct(private string $value) {}

    public static function of(string $value): self {
        return new self($value);
    }

    public function value(): string {
        return $this->value;
    }
}
