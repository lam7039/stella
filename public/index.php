<?php

require_once __DIR__ . '/../bootstrap/application.php';

echo str('this is a second test');
exit;

$application = require_once __DIR__ . '/../app/application.php';

//$app->handleRequest(Request::capture());
