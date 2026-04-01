<?php

$app = new \Stella\Core\App;
$app->register(\Stella\Providers\LoggerServiceProvider::class);
$app->register(\Stella\Providers\StorageServiceProvider::class);
// $app->register(RouterServiceProvider::class);
// $app->register(DatabaseServiceProvider::class);

$app->boot();
