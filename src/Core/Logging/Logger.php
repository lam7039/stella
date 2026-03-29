<?php

namespace Stella\Core\Logging;

class Logger {
    private readonly string $debugFile;
    private readonly string $templateFile;

    public function __construct(?string $debugFile = null, ?string $templateFile = null) {
        $this->debugFile = storage_path($debugFile ?? 'debug.html');
        $this->templateFile = public_path($templateFile ?? 'templates/debug.html');
    }

    private function initialize(): void {
        if (is_file($this->debugFile)) {
            return;
        }

        if (! is_file($this->templateFile)) {
            throw new \RuntimeException("Template file missing: {$this->templateFile}");
        }

        if (
            ! copy($this->templateFile, $this->debugFile) &&
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
        // debug_print_backtrace();
        // exit;

        $this->initialize();

        [$file, $line] = $this->resolveCaller($file, $line);
        $row = $this->buildRow($message, $type, $file, $line);

        file_put_contents($this->debugFile, $row, FILE_APPEND | LOCK_EX);
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

    public function getContents(): string {
        $this->initialize();
        
        $contents = file_get_contents($this->debugFile);

        if (false === $contents) {
            throw new \RuntimeException("Failed to read debug file: {$this->debugFile}");
        }

        return $contents;
    }
}
