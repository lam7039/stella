<?php

$router = app()->get(\Stella\Core\Routing\Router::class);

$router->get('/test', function() {
    return new \Stella\Core\Http\Response\JsonResponse('Hello, World!');
});
