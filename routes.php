<?php

use FastRoute\RouteCollector;
use Admin\Controllers;

$route->addRoute('GET', '/', '/**/');
$route->addRoute('GET', '/login', 'Admin\Controllers');

$route->addGroup('/admin', function (RouteCollector $route) {
    $route->addRoute('GET', '/users', 'get_all_users_handler');
    $route->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
    $route->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});