<?php

namespace Stella\Support\Traits\Str;

trait CastTrait
{
    use StringTrait;

    public function int(int $base = 10): int
    {
        return intval($this->value(), $base);
    }

    public function float(): float
    {
        return floatval($this->value());
    }

    public function bool(): bool
    {
        return filter_var($this->value(), FILTER_VALIDATE_BOOLEAN);
    }

    public function array(bool $associative = false): array
    {
        $value = json_decode($this->value(), $associative);

        if (! is_array($value)) {
            throw new \Exception; //TODO: JsonDecodeException;
        }

        return $value;
    }

    public function json(): string
    {
        return json_encode($this->value(), JSON_THROW_ON_ERROR);
    }

    public function toBase64(): string
    {
        return base64_encode($this->value());
    }

    public function fromBase64(bool $strict = true): string
    {
        $decoded = base64_decode($this->value(), $strict);

        if ($decoded === false) {
            throw new \Exception; //TODO: Base64DecodeException;
        }

        return $decoded;
    }
}
