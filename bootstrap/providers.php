<?php

$app->register(\Stella\Providers\ConfigServiceProvider::class);
$app->register(\Stella\Providers\ExceptionServiceProvider::class);
$app->register(\Stella\Providers\StorageServiceProvider::class);
$app->register(\Stella\Providers\LoggerServiceProvider::class);

$app->register(\Stella\Providers\HttpServiceProvider::class);
$app->register(\Stella\Providers\PipelineServiceProvider::class);
$app->register(\Stella\Providers\RouterServiceProvider::class);
// $app->register(\Stella\Providers\MiddlewareServiceProvider::class);
// $app->register(\Stella\Providers\DatabaseServiceProvider::class);

