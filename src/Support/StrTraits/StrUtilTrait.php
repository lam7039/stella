<?php

namespace Stella\Support\StrTraits;

trait StrUtilTrait {
    public function length(): int {
        return mb_strlen($this->value);
    }

    public function limit(int $limit, string $end = '...'): self {
        if ($this->length() > $limit) {
            return mb_substr($this->value, 0, $limit) . $end;
        }

        return $this->value;
    }
}
