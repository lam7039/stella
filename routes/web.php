<?php

$router = app()->get(\Stella\Core\Routing\Router::class);

$router->get('/', redirect('/home'));
$router->get('/home', new \Stella\Core\Http\Response\HtmlResponse('<h1>Hello, World!</h1>'));
