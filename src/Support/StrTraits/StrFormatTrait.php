<?php

namespace Stella\Support\StrTraits;

trait StrFormatTrait {
    public function camel(): static {
        $value = preg_replace('/[\s\-_]+/', ' ', $this->value);
        $value = mb_convert_case($value, MB_CASE_TITLE);
        $value = str_replace(' ', '', $value);
        return $this->new(mb_lcfirst($value));
    }

    public function pascal(): static {
        return $this->new(mb_ucfirst($this->camel()->value()));
    }

    public function snake(): static {
        $value = preg_replace('/[A-Z]/', '_$0', $this->value);
        $value = mb_strtolower(trim($value, '_'));
        $value = str_replace(' ', '_', $value);
        return $this->new($value);
    }

    public function slug(): static {
        $value = preg_replace('/[^A-Za-z0-9]+/', '-', $this->value);
        $value = mb_strtolower(trim($value, '-'));
        return $this->new($value);
    }
}
