<?php

\Stella\Core\DotEnv::load();

$config = [];

$files = glob(config_path('*.php'));
sort($files);

foreach ($files as $file) {
    $name = basename($file, '.php');
    $config[$name] = require $file;
}

\Stella\Core\Config::load($config);
