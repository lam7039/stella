<?php

namespace Stella\Core;

class DotEnv {
    private static array $items = [];

    public static function load(?string $path = null): void {
        $path ??= env_path();

        if (! file_exists($path)) {
            // LOG_WARNING('Environment file does not exist');
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            if (! $line || str_starts_with($line, '#')) {
                continue;
            }

            if (! str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);

            $key = trim($key);
            $value = trim($value);
            $value = trim($value, '"\'');

            self::$items[$key] = $value;
            $_ENV[$key] = $value;
        }
    }

    public static function get(string $key, mixed $default = null): mixed {
        $value = self::$items[$key] ?? $_ENV[$key] ?? $default;
        return self::cast($value);
    }

    public static function has(string $key): bool {
        return isset(self::$items[$key]) || isset($_ENV[$key]);
    }

    private static function cast(mixed $value) {
        if (! is_string($value)) {
            return $value;
        }

        return match (strtolower($value)) {
            'true', '(true)' => true,
            'false', '(false)' => false,
            'null', '(null)' => null,
            'empty', '(empty)' => '',
            default => is_numeric($value)
                ? (str_contains($value, '.') ? (float) $value : (int) $value)
                : $value,
        };
    }
}
