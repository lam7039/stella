<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/polyfills.php';
require_once __DIR__ . '/helpers.php';

if (function_exists('mb_internal_encoding')) {
    mb_internal_encoding(config('app.encoding'));
}

if (function_exists('mb_http_output')) {
    mb_http_output(config('app.encoding'));
}

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
