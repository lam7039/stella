<?php

namespace Stella\Core\Exceptions;

use Stella\Core\Logging\ErrorType;
use Throwable;

class Handler
{
    public function register(): void
    {
        set_exception_handler([$this, 'handleException']);
        set_error_handler([$this, 'handleError']);
        register_shutdown_function([$this, 'handleShutdown']);
    }

    public function handleException(Throwable $e): void
    {
        logger()->critical(
            sprintf('%s: %s', $e::class, $e->getMessage()),
            $e->getFile(),
            $e->getLine()
        );

        http_response_code(500);

        if (config('app.debug')) {
            echo logger()->getContents();
            return;
        }

        echo 'Internal Server Error';
    }

    public function handleError(int $severity, string $message, string $file, int $line): bool
    {
        logger()->append(
            $message,
            ErrorType::fromCode($this->mapSeverity($severity)),
            $file,
            $line
        );

        return true;
    }

    public function handleShutdown(): void
    {
        $error = error_get_last();

        if (! $error || ! in_array($error['type'], [
            E_ERROR,
            E_PARSE,
            E_CORE_ERROR,
            E_COMPILE_ERROR,
        ])) {
            return;
        }

        logger()->critical(
            $error['message'],
            $error['file'],
            $error['line']
        );
    }

    private function mapSeverity(int $severity): int
    {
        return match ($severity) {
            E_NOTICE,
            E_USER_NOTICE => 1,

            E_WARNING,
            E_USER_WARNING => 2,

            E_ERROR,
            E_USER_ERROR,
            E_PARSE,
            E_CORE_ERROR,
            E_COMPILE_ERROR => 3,

            default => 0,
        };
    }
}
