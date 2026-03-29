<?php

namespace Stella\Core;

class Config {
    private static array $items = [];

    public static function load(array $config): void {
        self::$items = $config;
    }

    public static function get(string $key, mixed $default = null): mixed {
        $keys = explode('.', $key);
        $value = self::$items;

        foreach ($keys as $k) {
            if (! isset($value[$k])) {
                return $default;
            }

            $value = $value[$k];
        }

        return $value;
    }
    
    public static function has(string $key): bool {
        $keys = explode('.', $key);
        $value = self::$items;

        foreach ($keys as $k) {
            if (! isset($value[$k])) {
                return false;
            }

            $value = $value[$k];
        }

        return true;
    }
}
