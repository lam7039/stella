<?php

namespace Stella\Support;

use Stella\Support\Traits\Str\{
    CaseTrait,
    TrimTrait,
    SearchTrait,
    CastTrait,
    FormatTrait,
    MutateTrait,
    ValidationTrait,
    UtilTrait
};

final class Str {
    use CaseTrait;
    use TrimTrait;
    use SearchTrait;
    use CastTrait;
    use FormatTrait;
    use MutateTrait;
    use ValidationTrait;
    use UtilTrait;

    public function __construct(private readonly string $value = '') {}

    public static function of(string $value): self {
        return new self($value);
    }

    protected function with(string $value): self {
        return self::of($value);
    }

    public function value(): string {
        return $this->value;
    }

    public function __toString(): string {
        return $this->value();
    }
}
