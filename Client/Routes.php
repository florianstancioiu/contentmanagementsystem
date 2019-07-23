<?php

use FastRoute\RouteCollector;

$route = new RouteCollector();

$route->addRoute('GET', '/users', 'get_all_users_handler');
$route->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
$route->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');