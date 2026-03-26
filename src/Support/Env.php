<?php

namespace Stella\Support;

class Env {
    private array $env = [];

    public function __construct() {
        $environment_file = file_get_contents('.env', true);
        $lines = explode(PHP_EOL, $environment_file);

        foreach ($lines as $line) {
            $line = trim($line);
            if (! $line) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $this->env[$key] = trim($value);
        }
    }

    public function get(string $key) : string|null {
        if(! isset($this->env[$key])) {
            // LOG_WARNING('Environment key does not exist');
            return null;
        }
        return $this->env[$key];
    }
}
