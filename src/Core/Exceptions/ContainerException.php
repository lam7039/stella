<?php

namespace Stella\Core\Exceptions;

use Exception;

class ContainerException extends Exception {
    public static function ClassNotFound(string $class) : self {
        return new self('Could not find class: ' . $class, 3);
    }

    public static function MethodNotFound(string $method) : self {
        return new self('Could not find method: ' . $method, 3);
    }

    public static function ParameterNotFound(string $parameter) : self {
        return new self('Could not find parameter: ' . $parameter, 3);
    }

    public static function InstanceNotFound(string $instance) : self {
        return new self('Instance does not exist: ' . $instance, 3);
    }

    public static function InvalidInstance(string $instance) : self {
        return new self('Could not instantiate: ' . $instance, 3);
    }

    public static function InvalidIntersection(string $class, string $parameter) : self {
        return new self("Failed to resolve class '$class' because of intersection type for parameter '$parameter'", 3);
    }

    public static function InvalidParameter(string $class, string $parameter) : self {
        return new self("Failed to resolve class '$class' because of invalid parameter '$parameter'", 3);
    }
}
