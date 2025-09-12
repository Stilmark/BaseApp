<?php
use FastRoute\RouteCollector;
use Stilmark\Base\AuthMiddleware;

// Public routes (no authentication required)
$r->addGroup('/list', function (RouteCollector $r) {
    $r->addRoute('GET', '/staticVars', 'ListController@staticVars');
});

// Auth routes
$r->addGroup('/signin', function (RouteCollector $r) {
    $r->addRoute('GET', '/{provider:(?:google|microsoft)}/callout', 'AuthController@callout');
    $r->addRoute('GET', '/{provider:(?:google|microsoft)}/callback', 'AuthController@callback');
});
$r->addRoute('GET', '/logout', 'AuthController@logout');


// Protected API routes (authentication required)
$r->addGroup('/api', function (RouteCollector $r) {
    $middlewares = ['middlewares' => [AuthMiddleware::class]];

    $r->addRoute('GET', '/user/{id:\d+}', ['UserController@index', $middlewares]);
});