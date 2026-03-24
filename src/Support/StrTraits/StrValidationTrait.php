<?php

namespace Stella\Support\StrTraits;

trait StrValidationTrait {
    public function isEmpty(): bool {
        return trim($this->value) === '';
    }

    public function isNumeric(): bool {
        return is_numeric($this->value);
    }

    public function isEmail(): bool {
        return filter_var($this->value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
