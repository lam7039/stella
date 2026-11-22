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
    EscapeTrait,
    UtilTrait,
};

final class Str
{
    use CaseTrait;
    use TrimTrait;
    use SearchTrait;
    use CastTrait;
    use FormatTrait;
    use MutateTrait;
    use ValidationTrait;
    use EscapeTrait;
    use UtilTrait;

    public function __construct(private readonly string $value = '') {}

    public static function of(string $value): static
    {
        return new static($value);
    }

    protected function newInstanceOf(string $value): static
    {
        return static::of($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }
}
