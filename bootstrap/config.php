<?php

\Stella\Core\Config\DotEnv::load();

$config = [];

$files = glob(config_path('*.php'));
sort($files);

foreach ($files as $file) {
    $name = basename($file, '.php');
    $config[$name] = require $file;
}

\Stella\Core\Config\Config::load($config);
