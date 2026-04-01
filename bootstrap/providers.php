<?php

$app = new \Stella\Core\App;
$app->register(\Stella\Providers\LoggerServiceProvider::class);
$app->register(\Stella\Providers\StorageServiceProvider::class);
// $app->register(\Stella\Providers\RouterServiceProvider::class);
// $app->register(\Stella\Providers\DatabaseServiceProvider::class);

$app->boot();
