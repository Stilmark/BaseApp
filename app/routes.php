<?php
use FastRoute\RouteCollector;
use Stilmark\Base\AuthMiddleware;

// Public routes (no authentication required)
$r->addGroup('/list', function (RouteCollector $r) {
    $r->addRoute('GET', '/staticVars', 'ListController@staticVars');
});

$r->addGroup('/signin', function (RouteCollector $r) {    
    $r->addRoute('GET', '/google/callout', 'AuthController@callout');
    $r->addRoute('GET', '/google/callback', 'AuthController@callback');
});

// // Protected API routes (authentication required)
// $r->addGroup('/api', function (RouteCollector $r) {
//     // User routes
//     $r->addRoute('GET', '/user/{id:\d+}', 'UserController@index');
//     $r->addRoute('POST', '/user', 'UserController@create');
//     $r->addRoute('PUT', '/user/{id:\d+}', 'UserController@update');
//     $r->addRoute('DELETE', '/user/{id:\d+}', 'UserController@delete');
    
//     $r->addRoute('GET', '/list/dynamic', 'ListController@dynamicVars');
    
// }, ['middlewares' => [AuthMiddleware::class]]);


// Protected API routes (authentication required)
$r->addGroup('/api', function (RouteCollector $r) {
    $middlewares = ['middlewares' => [AuthMiddleware::class]];

    $r->addRoute('GET', '/user/{id:\d+}', ['UserController@index', $middlewares]);
});