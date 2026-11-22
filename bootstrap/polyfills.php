<?php
/*
|--------------------------------------------------------------------------
| Polyfills
|--------------------------------------------------------------------------
|
| Provides basic compatibility implementations for optional PHP
| extensions. These implementations may have reduced functionality.
|
*/

if (! defined('MB_CASE_UPPER')) {
    define('MB_CASE_UPPER', 0);
}

if (! defined('MB_CASE_LOWER')) {
    define('MB_CASE_LOWER', 1);
}

if (! defined('MB_CASE_TITLE')) {
    define('MB_CASE_TITLE', 2);
}

if (! function_exists('mb_strlen')) {
    function mb_strlen(string $string, ?string $encoding = null): int
    {
        return strlen($string);
    }
}

if (! function_exists('mb_substr')) {
    function mb_substr(string $string, int $start, ?int $length = null, ?string $encoding = null): string
    {
        return substr($string, $start, $length);
    }
}

if (! function_exists('mb_strtolower')) {
    function mb_strtolower(string $string, ?string $encoding = null): string
    {
        return strtolower($string);
    }
}

if (! function_exists('mb_strtoupper')) {
    function mb_strtoupper(string $string, ?string $encoding = null): string
    {
        return strtoupper($string);
    }
}

if (! function_exists('mb_ucfirst')) {
    function mb_ucfirst(string $string, ?string $encoding = null): string
    {
        return ucfirst($string);
    }
}

if (! function_exists('mb_lcfirst')) {
    function mb_lcfirst(string $string, ?string $encoding = null): string
    {
        return lcfirst($string);
    }
}

if (! function_exists('mb_convert_case')) {
    function mb_convert_case(string $string, int $mode, ?string $encoding = null): string
    {
        return match ($mode) {
            MB_CASE_UPPER => mb_strtoupper($string, $encoding),
            MB_CASE_LOWER => mb_strtolower($string, $encoding),
            MB_CASE_TITLE => ucwords(mb_strtolower($string, $encoding)),
            default => $string,
        };
    }
}
