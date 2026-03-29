<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (in_array($uri, ['/favicon.ico', '/robots.txt', '/apple-touch-icon.png'])) {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../bootstrap/app.php';

date_default_timezone_set(config('app.timezone'));

throw new Exception('This is a test exception to verify the logger and exception handler are working correctly.');

dd(config('app.name'));


//$app->handleRequest(Request::capture());
