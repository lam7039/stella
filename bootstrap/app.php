<?php
declare(strict_types=1);

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/polyfills.php';
require_once __DIR__ . '/helpers.php';

$context = new \Stella\Core\ApplicationContext(
    environment: config('app.environment', 'development'),
    debug: config('app.debug', true),
);

$app = new \Stella\Core\App($context);

require_once __DIR__ . '/providers.php';

$app->boot();

$response = $app->run();

$emitter = new \Stella\Core\Http\ResponseEmitter;
$emitter->emit($response);
