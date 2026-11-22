<?php

namespace Stella\Support\Traits\Str;

trait EscapeTrait
{
    public function html(
        int $flags = ENT_QUOTES | ENT_SUBSTITUTE,
        ?string $encoding = 'UTF-8',
        bool $doubleEncode = true
    ): static
    {
        return $this->newInstanceOf(htmlspecialchars($this->value(), $flags, $encoding, $doubleEncode));
    }

    public function htmlDecode(int $flags = ENT_QUOTES | ENT_SUBSTITUTE): static
    {
        return $this->newInstanceOf(htmlspecialchars_decode($this->value(), $flags));
    }

    public function entityDecode(
        int $flags = ENT_QUOTES | ENT_SUBSTITUTE,
        ?string $encoding = 'UTF-8'
    ): static
    {
        return $this->newInstanceOf(html_entity_decode($this->value(), $flags, $encoding));
    }

    public function urlEncode(): static
    {
        return $this->newInstanceOf(rawurlencode($this->value()));
    }

    public function urlDecode(): static
    {
        return $this->newInstanceOf(rawurldecode($this->value()));
    }
}
