<?php

use FastRoute\RouteCollector;

$route->addRoute('GET', '/signin', 'Common\Auth@showSignin');
$route->addRoute('POST', '/signin', 'Common\Auth@signin');
$route->addRoute('GET', '/signup', 'Common\Auth@showSignup');
$route->addRoute('POST', '/signup', 'Common\Auth@signup');
$route->addRoute('GET', '/signout', 'Common\Auth@signout');

$route->addGroup('/admin', function (RouteCollector $route) {
    $route->addRoute('GET', '', 'Admin\Controllers\PagesController@index');
    $route->addRoute('GET', '/pages', 'Admin\Controllers\PagesController@index');
    $route->addRoute('POST', '/pages', 'Admin\Controllers\PagesController@store');
    $route->addRoute('GET', '/pages/create', 'Admin\Controllers\PagesController@create');
    $route->addRoute('GET', '/pages/edit/{id}', 'Admin\Controllers\PagesController@edit');
    $route->addRoute('GET', '/pages/destroy/{id}', 'Admin\Controllers\PagesController@destroy');
    $route->addRoute('GET', '/pages/{id}', 'Admin\Controllers\PagesController@edit');
    $route->addRoute('POST', '/pages/{id}', 'Admin\Controllers\PagesController@update');

    $route->addRoute('GET', '/posts', 'Admin\Controllers\PostsController@index');
    $route->addRoute('POST', '/posts', 'Admin\Controllers\PostsController@store');
    $route->addRoute('GET', '/posts/{id}', 'Admin\Controllers\PostsController@edit');
    $route->addRoute('POST', '/posts/{id}', 'Admin\Controllers\PostsController@update');

    $route->addRoute('GET', '/comments', 'Admin\Controllers\CommentsController@index');
    $route->addRoute('POST', '/comments', 'Admin\Controllers\CommentsController@store');
    $route->addRoute('GET', '/comments/{id}', 'Admin\Controllers\CommentsController@edit');
    $route->addRoute('POST', '/comments/{id}', 'Admin\Controllers\CommentsController@update');

    $route->addRoute('GET', '/users', 'Admin\Controllers\UsersController@index');
    $route->addRoute('POST', '/users', 'Admin\Controllers\UsersController@store');
    $route->addRoute('GET', '/users/{id}', 'Admin\Controllers\UsersController@edit');
    $route->addRoute('POST', '/users/{id}', 'Admin\Controllers\UsersController@update');
});
