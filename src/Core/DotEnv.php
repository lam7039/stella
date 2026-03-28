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

    public static function get(string $key, mixed $default = null): ?string {
        return self::$items[$key] ?? $_ENV[$key] ?? $default;
    }

    public static function has(string $key): bool {
        return isset(self::$items[$key]) || isset($_ENV[$key]);
    }
}
