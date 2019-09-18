<?php

use FastRoute\RouteCollector;

// TODO: Handle multiple languages by using a slug prefix
$route->addRoute('GET', '/', 'Controllers\Client\FrontendController@home');
$route->addRoute('GET', '/about', 'Controllers\Client\FrontendController@about');
$route->addRoute('GET', '/contact', 'Controllers\Client\FrontendController@showContact');
$route->addRoute('POST', '/contact', 'Controllers\Client\FrontendController@contact');
$route->addRoute('GET', '/login', 'Controllers\Client\FrontendController@showLogin');
$route->addRoute('POST', '/login', 'Controllers\Client\FrontendController@login');
$route->addRoute('GET', '/register', 'Controllers\Client\FrontendController@showRegister');
$route->addRoute('POST', '/register', 'Controllers\Client\FrontendController@register');

$route->addRoute('GET', '/signin', 'Common\Auth@showSignin');
$route->addRoute('POST', '/signin', 'Common\Auth@signin');
$route->addRoute('GET', '/signup', 'Common\Auth@showSignup');
$route->addRoute('POST', '/signup', 'Common\Auth@signup');
$route->addRoute('GET', '/signout', 'Common\Auth@signout');

$route->addGroup('/admin', function (RouteCollector $route) {
    $route->addRoute('GET', '', 'Controllers\Admin\PagesController@index');
    $route->addRoute('GET', '/pages', 'Controllers\Admin\PagesController@index');
    $route->addRoute('POST', '/pages', 'Controllers\Admin\PagesController@store');
    $route->addRoute('GET', '/pages/create', 'Controllers\Admin\PagesController@create');
    $route->addRoute('GET', '/pages/edit/{id}', 'Controllers\Admin\PagesController@edit');
    $route->addRoute('GET', '/pages/destroy/{id}', 'Controllers\Admin\PagesController@destroy');
    $route->addRoute('GET', '/pages/{id}', 'Controllers\Admin\PagesController@edit');
    $route->addRoute('POST', '/pages/{id}', 'Controllers\Admin\PagesController@update');

    $route->addRoute('GET', '/posts', 'Controllers\Admin\PostsController@index');
    $route->addRoute('POST', '/posts', 'Controllers\Admin\PostsController@store');
    $route->addRoute('GET', '/posts/create', 'Controllers\Admin\PostsController@create');
    $route->addRoute('GET', '/posts/edit/{id}', 'Controllers\Admin\PostsController@edit');
    $route->addRoute('GET', '/posts/destroy/{id}', 'Controllers\Admin\PostsController@destroy');
    $route->addRoute('GET', '/posts/{id}', 'Controllers\Admin\PostsController@edit');
    $route->addRoute('POST', '/posts/{id}', 'Controllers\Admin\PostsController@update');

    $route->addRoute('GET', '/trees', 'Controllers\Admin\TreesController@index');
    $route->addRoute('POST', '/trees', 'Controllers\Admin\TreesController@store');
    $route->addRoute('GET', '/trees/create', 'Controllers\Admin\TreesController@create');
    $route->addRoute('GET', '/trees/edit/{id}', 'Controllers\Admin\TreesController@edit');
    $route->addRoute('GET', '/trees/destroy/{id}', 'Controllers\Admin\TreesController@destroy');
    $route->addRoute('GET', '/trees/{id}', 'Controllers\Admin\TreesController@edit');
    $route->addRoute('POST', '/trees/{id}', 'Controllers\Admin\TreesController@update');

    $route->addRoute('GET', '/vegetables', 'Controllers\Admin\VegetablesController@index');
    $route->addRoute('POST', '/vegetables', 'Controllers\Admin\VegetablesController@store');
    $route->addRoute('GET', '/vegetables/create', 'Controllers\Admin\VegetablesController@create');
    $route->addRoute('GET', '/vegetables/edit/{id}', 'Controllers\Admin\VegetablesController@edit');
    $route->addRoute('GET', '/vegetables/destroy/{id}', 'Controllers\Admin\VegetablesController@destroy');
    $route->addRoute('GET', '/vegetables/{id}', 'Controllers\Admin\VegetablesController@edit');
    $route->addRoute('POST', '/vegetables/{id}', 'Controllers\Admin\VegetablesController@update');

    $route->addRoute('GET', '/comments', 'Controllers\Admin\CommentsController@index');
    $route->addRoute('POST', '/comments', 'Controllers\Admin\CommentsController@store');
    $route->addRoute('GET', '/comments/{id}', 'Controllers\Admin\CommentsController@edit');
    $route->addRoute('POST', '/comments/{id}', 'Controllers\Admin\CommentsController@update');

    $route->addRoute('GET', '/users', 'Controllers\Admin\UsersController@index');
    $route->addRoute('POST', '/users', 'Controllers\Admin\UsersController@store');
    $route->addRoute('GET', '/users/create', 'Controllers\Admin\UsersController@create');
    $route->addRoute('GET', '/users/edit/{id}', 'Controllers\Admin\UsersController@edit');
    $route->addRoute('GET', '/users/destroy/{id}', 'Controllers\Admin\UsersController@destroy');
    $route->addRoute('GET', '/users/{id}', 'Controllers\Admin\UsersController@edit');
    $route->addRoute('POST', '/users/{id}', 'Controllers\Admin\UsersController@update');
});

$route->addRoute('GET', '/trees', 'Controllers\Client\TreesController@index');
$route->addRoute('GET', '/trees/{slug}', 'Controllers\Client\TreesController@show');

$route->addRoute('GET', '/fruits', 'Controllers\Client\FruitsController@index');
$route->addRoute('GET', '/fruits/{slug}', 'Controllers\Client\FruitsController@show');

$route->addRoute('GET', '/vegetables', 'Controllers\Client\VegetablesController@index');
$route->addRoute('GET', '/vegetables/{slug}', 'Controllers\Client\VegetablesController@show');

$route->addRoute('GET', '/drinks', 'Controllers\Client\DrinksController@index');
$route->addRoute('GET', '/drinks/{slug}', 'Controllers\Client\DrinksController@show');

$route->addRoute('GET', '/{slug}', 'Controllers\Client\PagesController@show');
