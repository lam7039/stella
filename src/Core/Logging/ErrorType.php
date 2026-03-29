<?php

namespace Stella\Core\Logging;

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
