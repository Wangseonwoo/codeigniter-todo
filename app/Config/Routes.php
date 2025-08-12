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
        // 회원가입
        $routes->post('register', 'UserController::register');

        // 회원 목록 조회
        $routes->get('/', 'UserController::getUserList');

        // 회원 상세 조회
        $routes->get('(:num)', 'UserController::getUser/$1');
    },
);
