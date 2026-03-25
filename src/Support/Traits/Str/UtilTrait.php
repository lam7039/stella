<?php

namespace Stella\Support\Traits\Str;

trait UtilTrait {
    public function length(): int {
        return mb_strlen($this->value());
    }

    public function limit(int $limit, string $end = '...'): self {
        if ($this->length() > $limit) {
            return $this->with(mb_substr($this->value(), 0, $limit) . $end);
        }

        return $this->with($this->value());
    }
}
