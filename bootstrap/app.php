<?php
declare(strict_types=1);

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/helpers.php';

$context = new \Stella\Core\ApplicationContext(
    environment: env('APP_ENV', 'development'),
    debug: env('APP_DEBUG', true),
);

$app = new \Stella\Core\App($context);

require_once __DIR__ . '/providers.php';

$app->boot();

$response = $app->run();

$emitter = new \Stella\Core\Http\ResponseEmitter;
$emitter->emit($response);
