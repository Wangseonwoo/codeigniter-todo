<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group(
    'users',
    [
        'namespace' => 'App\Controllers',
    ],
    function ($routes) {
        $routes->match(['post'], 'register', 'UserController::register');
    },
);
