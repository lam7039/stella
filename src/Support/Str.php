<?php

namespace Stella\Support;

use Stella\Support\StrTraits\{
    StrCaseTrait,
    StrTrimTrait,
    StrSearchTrait,
    StrCastTrait,
    StrFormatTrait,
    StrMutateTrait,
    StrValidationTrait,
    StrUtilTrait
};

final class Str {
    use StrCaseTrait;
    use StrTrimTrait;
    use StrSearchTrait;
    use StrCastTrait;
    use StrFormatTrait;
    use StrMutateTrait;
    use StrValidationTrait;
    use StrUtilTrait;

    public function __construct(private readonly string $value) {}

    protected function new(string $value): self {
        return new self($value);
    }

    public static function of(string $value): self {
        return $this->new($value);
    }

    public function value(): string {
        return $this->value;
    }

    public function __toString(): string {
        return $this->value;
    }
}
