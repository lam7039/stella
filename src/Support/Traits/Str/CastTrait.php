<?php

namespace Stella\Support\Traits\Str;

trait CastTrait {
    public function int(int $base = 10): int {
        return intval($this->value(), $base);
    }

    public function float(): float {
        return floatval($this->value());
    }

    public function bool(): bool {
        return boolval($this->value());
    }
    
    public function array(bool $associative = false): array {
        return json_decode($this->value(), $associative);
    }

    public function json(): string {
        return json_encode($this->value());
    }

    public function toBase64(): string {
        return base64_encode($this->value());
    }

    public function fromBase64(bool $strict = true): string {
        if (! $decoded = base64_decode($this->value(), $strict)) {
            throw new Exception; //TODO: Base64DecodeException;
        }

        return $decoded;
    }
}
