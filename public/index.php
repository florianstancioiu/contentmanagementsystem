<?php

use Common\Database;

error_reporting(E_ALL);
error_log(-1);

// autoload composer classes and files
require '../vendor/autoload.php';

// start the session
session_start();

// Enable Twig Extensions
require '../common/Twig.php';

// Require the helper functions
require '../helpers.php';

// Create storage symlink
$storage_symlink = PUBLIC_PATH . DS . 'storage';

if (! file_exists($storage_symlink)) {
  symlink(STORAGE_PATH, $storage_symlink);
}

// Use the fastroute library
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $route) {
    require_once base_dir() . DS . 'routes.php';
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        // make the anonymous functions work
        if (is_object($handler)) {
            call_user_func($handler, $vars);
        }

        // make the classes work
        list($class, $method) = explode("@", $handler, 2);
        call_user_func_array(array(new $class, $method), $vars);

        break;
}
