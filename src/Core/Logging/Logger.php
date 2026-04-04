<?php

namespace Stella\Core\Logging;

use Stella\Support\File;

class Logger {
    private readonly File $debugFile;
    private readonly File $templateFile;

    public function __construct(?string $debugFile = null, ?string $templateFile = null) {
        $this->debugFile = file_object(storage_path($debugFile ?? 'logs/debug.html'));
        $this->templateFile = file_object(public_path($templateFile ?? 'templates/debug.html'));

        File::mkdir(__DIR__ . '/../../../storage/logs');
    }

    private function initialize(): void {
        if ($this->debugFile->exists()) {
            return;
        }

        if (! $this->templateFile->exists()) {
            throw new \RuntimeException("Template file missing: {$this->templateFile->path()}");
        }

        if (! $this->templateFile->copy($this->debugFile->path())) {
            throw new \RuntimeException("Failed to create debug file: {$this->debugFile->path()}");
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

        $this->debugFile->append($row);
    }
    
    public function reset(): void {
        if ($this->debugFile->remove()) {
            $this->initialize();
        }
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

        return $this->debugFile->contents();
    }
}
