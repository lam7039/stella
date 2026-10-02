<?php

$router = app()->get(\Stella\Core\Routing\Router::class);

$router->get('/', redirect('/home'));

$router->get('/home', function() {
    return new \Stella\Core\Http\Response\JsonResponse('Hello, World!');
});
