<?php

spl_autoload_register(function ($class) {
    $base = __DIR__ . '/../src/';

    $parts = explode('\\', $class);
    array_shift($parts);
    $path = implode('/', $parts);

    $file = $base . $path . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});