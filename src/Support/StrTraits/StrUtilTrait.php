<?php

namespace Stella\Support\StrTraits;

trait StrUtilTrait {
    public function length(): int {
        return mb_strlen($this->value);
    }

    public function limit(int $limit, string $end = '...'): static {
        if ($this->length() > $limit) {
            return $this->new(mb_substr($this->value, 0, $limit) . $end);
        }

        return $this->new($this->value);
    }
}
