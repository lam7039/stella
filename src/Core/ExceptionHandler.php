<?php

namespace Stella\Core;

class ExceptionHandler {
    public static function register(): void {
        set_exception_handler([self::class, 'handleException']);
        set_error_handler([self::class, 'handleError']);
        register_shutdown_function([self::class, 'handleShutdown']);
    }

    public static function handleException(\Throwable $e): void {
        logger()->critical(
            $e->getMessage(),
            $e->getfile(),
            $e->getLine()
        );

        http_response_code(500);

        if (config('app.debug')) {
            echo file_get_contents(storage_path('debug.html'));
            return;
        }

        echo 'Internal Server Error';
    }

    public static function handleError(int $severity, string $message, string $file, int $line): bool {
        logger()->append(
            $message,
            ErrorType::fromCode(self::mapSeverity($severity)),
            $file,
            $line
        );

        return true;
    }

    public static function handleShutdown(): void {
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

    private static function mapSeverity(int $severity): int {
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
