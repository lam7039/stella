<?php

namespace Stella\Support\StrTraits;

trait StrSearchTrait {
    public function contains(string $needle): bool {
        return str_contains($this->value(), $needle);
    }

    public function startsWith(string $needle): bool {
        return mb_substr($this->value(), 0, mb_strlen($needle)) === $needle;
    }

    public function endsWith(string $needle): bool {
        return mb_substr($this->value(), -mb_strlen($needle)) === $needle;
    }
}
