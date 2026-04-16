<?php

namespace Stella\Core\Config;

class DotEnv {
    private array $items = [];

    public function load(?string $path = null): void {
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

            $this->items[$key] = $value;
            $_ENV[$key] = $value;
        }
    }

    public function get(string $key, mixed $default = null): mixed {
        $value = $this->items[$key] ?? $_ENV[$key] ?? $default;
        return $this->cast($value);
    }

    public function has(string $key): bool {
        return isset($this->items[$key]) || isset($_ENV[$key]);
    }

    private function cast(mixed $value) {
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
