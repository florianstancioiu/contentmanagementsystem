<?php

use FastRoute\RouteCollector;

$route->addRoute('GET', '/signin', 'Common\Auth@showSignin');
$route->addRoute('POST', '/signin', 'Common\Auth@signin');

$route->addRoute('GET', '/signup', 'Common\Auth@showSignup');
$route->addRoute('POST', '/signup', 'Common\Auth@signup');

$route->addGroup('/admin', function (RouteCollector $route) {
    $route->addRoute('GET', '', 'Admin\Controllers\PagesController@index');
    $route->addRoute('GET', '/pages', 'Admin\Controllers\PagesController@index');
    $route->addRoute('POST', '/pages', 'Admin\Controllers\PagesController@store');
    $route->addRoute('GET', '/pages/{slug}', 'Admin\Controllers\PagesController@edit');
    $route->addRoute('POST', '/pages/{slug}', 'Admin\Controllers\PagesController@update');

    $route->addRoute('GET', '/posts', 'Admin\Controllers\PostsController@index');
    $route->addRoute('POST', '/posts', 'Admin\Controllers\PostsController@store');
    $route->addRoute('GET', '/posts/{slug}', 'Admin\Controllers\PostsController@edit');
    $route->addRoute('POST', '/posts/{slug}', 'Admin\Controllers\PostsController@update');

    $route->addRoute('GET', '/comments', 'Admin\Controllers\CommentsController@index');
    $route->addRoute('POST', '/comments', 'Admin\Controllers\CommentsController@store');
    $route->addRoute('GET', '/comments/{slug}', 'Admin\Controllers\CommentsController@edit');
    $route->addRoute('POST', '/comments/{slug}', 'Admin\Controllers\CommentsController@update');

    $route->addRoute('GET', '/users', 'Admin\Controllers\UsersController@index');
    $route->addRoute('POST', '/users', 'Admin\Controllers\UsersController@store');
    $route->addRoute('GET', '/users/{slug}', 'Admin\Controllers\UsersController@edit');
    $route->addRoute('POST', '/users/{slug}', 'Admin\Controllers\UsersController@update');
});
