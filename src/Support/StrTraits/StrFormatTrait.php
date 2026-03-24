<?php

namespace Stella\Support\StrTraits;

trait StrFormatTrait {
    public function camel(): self {
        $value = preg_replace('/[\s\-_]+/', ' ', $this->value);
        $value = ucwords($value);
        $value = str_replace(' ', '', $value);
        return new self(lcfirst($value));
    }

    public function pascal(): self {
        return new self(ucfirst($this->camel()->value()));
    }

    public function snake(): self {
        $value = preg_replace('/[A-Z]/', '_$0', $this->value);
        $value = strtolower(trim($value, '_'));
        $value = str_replace(' ', '_', $value);
        return new self($value);
    }

    public function slug(): self {
        $value = preg_replace('/[^A-Za-z0-9]+/', '-', $this->value);
        $value = strtolower(trim($value, '-'));
        return new self($value);
    }
}
