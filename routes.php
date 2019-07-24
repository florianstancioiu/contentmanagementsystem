<?php

use FastRoute\RouteCollector;
use Common\Auth\Controllers\LoginController;

$route->addRoute('GET', '/', 'Common\Auth\LoginController@showLogin');
$route->addGroup('/auth', function (RouteCollector $route) {
    $route->addRoute('GET', '/', function () {
        echo "some stuff";
    });
    $route->addRoute('POST', '/', 'Admin\Controllers\AuthController@login');
    $route->addRoute('GET', '/register', 'Admin\Controllers\AuthController@showRegister');
    $route->addRoute('POST', '/register', 'Admin\Controllers\AuthController@register');
});

$route->addGroup('/admin', function (RouteCollector $route) {
    $route->addRoute('GET', '/users', 'get_all_users_handler');
    $route->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
    $route->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});