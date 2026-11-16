<?php

namespace Stella\Core;

final readonly class ApplicationContext
{
    public function __construct(
        public string $environment,
        public bool $debug,
    )
    {
        if (!in_array($this->environment, ['production', 'development'])) {
            throw new \InvalidArgumentException("Invalid environment: {$this->environment}");
        }
    }

    public function isProduction(): bool {
        return $this->environment === 'production';
    }

    public function isDevelopment(): bool {
        return $this->environment === 'development';
    }
}
