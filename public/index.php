<?php

require_once __DIR__ . '/../bootstrap/app.php';

date_default_timezone_set(config('app.timezone'));

throw new Exception('This is a test exception to verify the logger and exception handler are working correctly.');

dd(config('app.name'));


//$app->handleRequest(Request::capture());
