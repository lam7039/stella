<?php

namespace Stella\Support\Traits\Str;

trait EscapeTrait {
    public function html(
        int $flags = ENT_QUOTES | ENT_SUBSTITUTE,
        ?string $encoding = 'UTF-8',
        bool $doubleEncode = true
    ): self {
        return $this->with(htmlspecialchars($this->value(), $flags, $encoding, $doubleEncode));
    }
}
