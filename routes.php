<?php

use FastRoute\RouteCollector;
use App\Controllers\Client as ClientCtrl;
use App\Controllers\Admin as AdminCtrl;

// TODO: Handle multiple languages by using a slug prefix
$route->addRoute('GET', '/', 'App\Controllers\Client\FrontendController@home');
$route->addRoute('GET', '/about', 'App\Controllers\Client\FrontendController@about');
$route->addRoute('GET', '/contact', 'App\Controllers\Client\FrontendController@showContact');
$route->addRoute('POST', '/contact', 'App\Controllers\Client\FrontendController@contact');
$route->addRoute('GET', '/login', 'App\Controllers\Client\FrontendController@showLogin');
$route->addRoute('POST', '/login', 'App\Controllers\Client\FrontendController@login');
$route->addRoute('GET', '/register', 'App\Controllers\Client\FrontendController@showRegister');
$route->addRoute('POST', '/register', 'App\Controllers\Client\FrontendController@register');

$route->addRoute('GET', '/signin', 'Common\Auth@showSignin');
$route->addRoute('POST', '/signin', 'Common\Auth@signin');
$route->addRoute('GET', '/signup', 'Common\Auth@showSignup');
$route->addRoute('POST', '/signup', 'Common\Auth@signup');
$route->addRoute('GET', '/signout', 'Common\Auth@signout');

$route->addGroup('/admin', function (RouteCollector $route) {
    $route->addRoute('GET', '', 'App\Controllers\Admin\PagesController@index');
    $route->addRoute('GET', '/pages', 'App\Controllers\Admin\PagesController@index');
    $route->addRoute('POST', '/pages', 'App\Controllers\Admin\PagesController@store');
    $route->addRoute('GET', '/pages/create', 'App\Controllers\Admin\PagesController@create');
    $route->addRoute('GET', '/pages/edit/{id}', 'App\Controllers\Admin\PagesController@edit');
    $route->addRoute('GET', '/pages/destroy/{id}', 'App\Controllers\Admin\PagesController@destroy');
    $route->addRoute('GET', '/pages/{id}', 'App\Controllers\Admin\PagesController@edit');
    $route->addRoute('POST', '/pages/{id}', 'App\Controllers\Admin\PagesController@update');

    $route->addRoute('GET', '/posts', 'App\Controllers\Admin\PostsController@index');
    $route->addRoute('POST', '/posts', 'App\Controllers\Admin\PostsController@store');
    $route->addRoute('GET', '/posts/create', 'App\Controllers\Admin\PostsController@create');
    $route->addRoute('GET', '/posts/edit/{id}', 'App\Controllers\Admin\PostsController@edit');
    $route->addRoute('GET', '/posts/destroy/{id}', 'App\Controllers\Admin\PostsController@destroy');
    $route->addRoute('GET', '/posts/{id}', 'App\Controllers\Admin\PostsController@edit');
    $route->addRoute('POST', '/posts/{id}', 'App\Controllers\Admin\PostsController@update');

    $route->addRoute('GET', '/trees', 'App\Controllers\Admin\TreesController@index');
    $route->addRoute('POST', '/trees', 'App\Controllers\Admin\TreesController@store');
    $route->addRoute('GET', '/trees/create', 'App\Controllers\Admin\TreesController@create');
    $route->addRoute('GET', '/trees/edit/{id}', 'App\Controllers\Admin\TreesController@edit');
    $route->addRoute('GET', '/trees/destroy/{id}', 'App\Controllers\Admin\TreesController@destroy');
    $route->addRoute('GET', '/trees/{id}', 'App\Controllers\Admin\TreesController@edit');
    $route->addRoute('POST', '/trees/{id}', 'App\Controllers\Admin\TreesController@update');

    $route->addRoute('GET', '/vegetables', 'App\Controllers\Admin\VegetablesController@index');
    $route->addRoute('POST', '/vegetables', 'App\Controllers\Admin\VegetablesController@store');
    $route->addRoute('GET', '/vegetables/create', 'App\Controllers\Admin\VegetablesController@create');
    $route->addRoute('GET', '/vegetables/edit/{id}', 'App\Controllers\Admin\VegetablesController@edit');
    $route->addRoute('GET', '/vegetables/destroy/{id}', 'App\Controllers\Admin\VegetablesController@destroy');
    $route->addRoute('GET', '/vegetables/{id}', 'App\Controllers\Admin\VegetablesController@edit');
    $route->addRoute('POST', '/vegetables/{id}', 'App\Controllers\Admin\VegetablesController@update');

    $route->addRoute('GET', '/comments', 'App\Controllers\Admin\CommentsController@index');
    $route->addRoute('POST', '/comments', 'App\Controllers\Admin\CommentsController@store');
    $route->addRoute('GET', '/comments/{id}', 'App\Controllers\Admin\CommentsController@edit');
    $route->addRoute('POST', '/comments/{id}', 'App\Controllers\Admin\CommentsController@update');

    $route->addRoute('GET', '/users', 'App\Controllers\Admin\UsersController@index');
    $route->addRoute('POST', '/users', 'App\Controllers\Admin\UsersController@store');
    $route->addRoute('GET', '/users/create', 'App\Controllers\Admin\UsersController@create');
    $route->addRoute('GET', '/users/edit/{id}', 'App\Controllers\Admin\UsersController@edit');
    $route->addRoute('GET', '/users/destroy/{id}', 'App\Controllers\Admin\UsersController@destroy');
    $route->addRoute('GET', '/users/{id}', 'App\Controllers\Admin\UsersController@edit');
    $route->addRoute('POST', '/users/{id}', 'App\Controllers\Admin\UsersController@update');

    $route->addRoute('GET', '/settings', 'App\Controllers\Admin\SettingsController@index');
});

$route->addRoute('GET', '/trees', 'App\Controllers\Client\TreesController@index');
$route->addRoute('GET', '/trees/{slug}', 'App\Controllers\Client\TreesController@show');

$route->addRoute('GET', '/fruits', 'App\Controllers\Client\FruitsController@index');
$route->addRoute('GET', '/fruits/{slug}', 'App\Controllers\Client\FruitsController@show');

$route->addRoute('GET', '/vegetables', 'App\Controllers\Client\VegetablesController@index');
$route->addRoute('GET', '/vegetables/{slug}', 'App\Controllers\Client\VegetablesController@show');

$route->addRoute('GET', '/drinks', 'App\Controllers\Client\DrinksController@index');
$route->addRoute('GET', '/drinks/{slug}', 'App\Controllers\Client\DrinksController@show');

$route->addRoute('GET', '/{slug}', 'App\Controllers\Client\PagesController@show');
