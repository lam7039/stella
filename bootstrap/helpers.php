<?php

use Stella\Support\Str;

if (! function_exists('str')) {
    function str(string $value): Str {
        return Str::of($value);
    }
}
