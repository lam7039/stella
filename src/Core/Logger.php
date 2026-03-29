<?php

namespace Stella\Core;

enum ErrorType : string {
    case Info = 'info';
    case Warning = 'warning';
    case Critical = 'critical';
    case Unknown = 'unknown';

    public static function fromCode(int $code) : ErrorType {
        return match($code) {
            1 => self::Info,
            2 => self::Warning,
            3 => self::Critical,
            default => self::Unknown,
        };
    }
};

class Logger {
    private readonly string $templatePath;
    private readonly string $debugFile;

    public function __construct() {
        $this->templatePath = public_path('templates/debug.html');
        $this->debugFile = storage_path('debug.html');
    }

    private function initialize(): void {
        if (is_file($this->debugFile)) {
            return;
        }

        if (! is_file($this->templatePath)) {
            throw new \RuntimeException("Template file missing: {$this->templatePath}");
        }

        if (
            ! copy($this->templatePath, $this->debugFile) &&
            ! is_file($this->debugFile)
        ) {
            throw new \RuntimeException("Failed to create debug file: {$this->debugFile}");
        }
    }

    public function append(
        string $message,
        ErrorType $type,
        ?string $file = null,
        ?int $line = null
    ): void {
        if (! is_file($this->debugFile)) {
            $this->initialize();
        }

        [$file, $line] = $this->resolveCaller($file, $line);
        $row = $this->buildRow($message, $type, $file, $line);

        $contents = file_get_contents($this->debugFile);
        $contents = str_replace('</tbody>', $row . PHP_EOL . '</tbody>', $contents);
        file_put_contents($this->debugFile, $contents, LOCK_EX);
    }
    
    public function reset(): void {
        if (is_file($this->debugFile)) {
            unlink($this->debugFile);
        }

        $this->initialize();
    }

    private function resolveCaller(?string $file, ?int $line): array {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2] ?? [];

        $file ??= isset($trace['file']) ? basename($trace['file']) : 'unknown';
        $line ??= $trace['line'] ?? 0;

        return [$file, $line];
    }

    //TODO: look into this
    // private function resolveCaller(?string $file, ?int $line): array {
    //     $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

    //     foreach ($trace as $frame) {
    //         if (($frame['class'] ?? null) !== self::class) {
    //             $file ??= isset($frame['file']) ? basename($frame['file']) : 'unknown';
    //             $line ??= $frame['line'] ?? 0;
    //             break;
    //         }
    //     }

    //     return [$file ?? 'unknown', $line ?? 0];
    // }

    private function buildRow(string $message, ErrorType $type, string $file, int $line): string {
        $timestamp = date('Y-m-d H:i:s');
        $message = htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $file = htmlspecialchars($file, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        return <<<HTML
            <tr class="{$type->value}">
                <td>{$timestamp}</td>
                <td>{$message}</td>
                <td>{$file}</td>
                <td>{$line}</td>
            </tr>
        HTML;
    }

    public function info(string $message, ?string $file = null, ?int $line = null): void {
        $this->append($message, ErrorType::Info, $file, $line);
    }

    public function warning(string $message, ?string $file = null, ?int $line = null): void {
        $this->append($message, ErrorType::Warning, $file, $line);
    }

    public function critical(string $message, ?string $file = null, ?int $line = null): void {
        $this->append($message, ErrorType::Critical, $file, $line);
    }
}
