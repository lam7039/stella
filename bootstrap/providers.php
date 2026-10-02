<?php

$app->register(new \Stella\Providers\ConfigServiceProvider);
$app->register(new \Stella\Providers\ExceptionServiceProvider);
$app->register(new \Stella\Providers\StorageServiceProvider);
$app->register(new \Stella\Providers\LoggerServiceProvider);

$app->register(new \Stella\Providers\HttpServiceProvider);
$app->register(new \Stella\Providers\PipelineServiceProvider);
$app->register(new \Stella\Providers\RouterServiceProvider);
// $app->register(new \Stella\Providers\MiddlewareServiceProvider);
// $app->register(new \Stella\Providers\DatabaseServiceProvider);
