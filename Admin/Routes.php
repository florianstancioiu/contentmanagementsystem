<?php

use FastRoute\RouteCollector;
use Admin\Controllers;

$route = new RouteCollector();

$route->addRoute('GET', '/users', 'CommentsController@index');
$route->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
$route->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');