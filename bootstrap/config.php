<?php

$config = [];
foreach (glob(__DIR__ . '/../config/*.php') as $file) {
    $name = basename($file, '.php');
    $config[$name] = require_once $file;
}
