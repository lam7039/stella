<?php
declare(strict_types=1);

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

set_include_path(__DIR__ . '/../');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/providers.php';
