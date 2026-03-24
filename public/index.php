<?php
declare(strict_types=1);

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');


// require __DIR__ . '/../src/core/autoload.php';

spl_autoload_register(function ($class) {
    $base = __DIR__ . '/../src/';

    $parts = explode('\\', $class);
    array_shift($parts);
    $path = implode('/', $parts);

    $file = $base . $path . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

use Stella\Support\Str;

echo Str::of('ThIs iS a tEst')->capitalize()->value();
exit;

$application = require_once __DIR__ . '/../src/core/application.php';

//$app->handleRequest(Request::capture());
