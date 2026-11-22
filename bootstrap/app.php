<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/polyfills.php';
require_once __DIR__ . '/helpers.php';

if (extension_loaded('mbstring')) {
    mb_internal_encoding(config('app.encoding', 'UTF-8'));
    mb_http_output(config('app.encoding', 'UTF-8'));
}

$context = new \Stella\Core\ApplicationContext(
    environment: config('app.env', 'development'),
    debug: config('app.debug', true),
);

$app = new \Stella\Core\App($context);

require_once __DIR__ . '/providers.php';

$app->boot();

$response = $app->run();

$emitter = new \Stella\Core\Http\ResponseEmitter;
$emitter->emit($response);
