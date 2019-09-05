<?php

use FastRoute\RouteCollector;

$route->addRoute('GET', '', 'Client\Controllers\HomeController@homepage');

$route->addRoute('GET', '/signin', 'Common\Auth@showSignin');
$route->addRoute('POST', '/signin', 'Common\Auth@signin');

$route->addRoute('GET', '/signup', 'Common\Auth@showSignup');
$route->addRoute('POST', '/signup', 'Common\Auth@signup');

$route->addRoute('GET', '/signout', 'Common\Auth@signout');

$route->addRoute('GET', '/pages', 'Admin\Controllers\PagesController@index');

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
    $route->addRoute('GET', '/posts/create', 'Admin\Controllers\PostsController@create');
    $route->addRoute('GET', '/posts/edit/{id}', 'Admin\Controllers\PostsController@edit');
    $route->addRoute('GET', '/posts/destroy/{id}', 'Admin\Controllers\PostsController@destroy');
    $route->addRoute('GET', '/posts/{id}', 'Admin\Controllers\PostsController@edit');
    $route->addRoute('POST', '/posts/{id}', 'Admin\Controllers\PostsController@update');

    $route->addRoute('GET', '/trees', 'Admin\Controllers\TreesController@index');
    $route->addRoute('POST', '/trees', 'Admin\Controllers\TreesController@store');
    $route->addRoute('GET', '/trees/create', 'Admin\Controllers\TreesController@create');
    $route->addRoute('GET', '/trees/edit/{id}', 'Admin\Controllers\TreesController@edit');
    $route->addRoute('GET', '/trees/destroy/{id}', 'Admin\Controllers\TreesController@destroy');
    $route->addRoute('GET', '/trees/{id}', 'Admin\Controllers\TreesController@edit');
    $route->addRoute('POST', '/trees/{id}', 'Admin\Controllers\TreesController@update');

    $route->addRoute('GET', '/vegetables', 'Admin\Controllers\VegetablesController@index');
    $route->addRoute('POST', '/vegetables', 'Admin\Controllers\VegetablesController@store');
    $route->addRoute('GET', '/vegetables/create', 'Admin\Controllers\VegetablesController@create');
    $route->addRoute('GET', '/vegetables/edit/{id}', 'Admin\Controllers\VegetablesController@edit');
    $route->addRoute('GET', '/vegetables/destroy/{id}', 'Admin\Controllers\VegetablesController@destroy');
    $route->addRoute('GET', '/vegetables/{id}', 'Admin\Controllers\VegetablesController@edit');
    $route->addRoute('POST', '/vegetables/{id}', 'Admin\Controllers\VegetablesController@update');

    $route->addRoute('GET', '/comments', 'Admin\Controllers\CommentsController@index');
    $route->addRoute('POST', '/comments', 'Admin\Controllers\CommentsController@store');
    $route->addRoute('GET', '/comments/{id}', 'Admin\Controllers\CommentsController@edit');
    $route->addRoute('POST', '/comments/{id}', 'Admin\Controllers\CommentsController@update');

    $route->addRoute('GET', '/users', 'Admin\Controllers\UsersController@index');
    $route->addRoute('POST', '/users', 'Admin\Controllers\UsersController@store');
    $route->addRoute('GET', '/users/create', 'Admin\Controllers\UsersController@create');
    $route->addRoute('GET', '/users/edit/{id}', 'Admin\Controllers\UsersController@edit');
    $route->addRoute('GET', '/users/destroy/{id}', 'Admin\Controllers\UsersController@destroy');
    $route->addRoute('GET', '/users/{id}', 'Admin\Controllers\UsersController@edit');
    $route->addRoute('POST', '/users/{id}', 'Admin\Controllers\UsersController@update');
});
