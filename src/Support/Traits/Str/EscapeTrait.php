<?php

namespace Stella\Support\Traits\Str;

trait EscapeTrait
{
    public function html(
        int $flags = ENT_QUOTES | ENT_SUBSTITUTE,
        ?string $encoding = 'UTF-8',
        bool $doubleEncode = true
    ): self {
        return $this->with(htmlspecialchars($this->value(), $flags, $encoding, $doubleEncode));
    }

    public function htmlDecode(int $flags = ENT_QUOTES | ENT_SUBSTITUTE): self
    {
        return $this->with(htmlspecialchars_decode($this->value(), $flags));
    }

    public function entityDecode(
        int $flags = ENT_QUOTES | ENT_SUBSTITUTE,
        ?string $encoding = 'UTF-8'
    ) {
        return $this->with(html_entity_decode($this->value(), $flags, $encoding));
    }

    public function urlEncode(): self
    {
        return $this->with(rawurlencode($this->value()));
    }

    public function urlDecode(): self
    {
        return $this->with(rawurldecode($this->value()));
    }
}
