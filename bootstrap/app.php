<?php
declare(strict_types=1);

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/helpers.php';

$app = new \Stella\Core\App;

require_once __DIR__ . '/providers.php';

$app->boot();

$response = $app->run();

$response->send();
