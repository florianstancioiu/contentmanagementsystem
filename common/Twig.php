<?php

$loader = new \Twig\Loader\FilesystemLoader(base_dir('resources' . DS . 'views'));
$twig_environment = new \Twig\Environment($loader, [
    'debug' => true,
    'autoload' => true,
    // NOTE: it's a good idea to give up the twig cache
    'cache' => base_dir('public' . DS . 'templatecache'),
]);

// register active_route function
$function = new \Twig\TwigFunction('active_route', function ($value) {
    return strpos(route(), $value) === 0 ? 'active-route' : '';
});
$twig_environment->addFunction($function);

// register url function
$function = new \Twig\TwigFunction('url', function ($value) {
    return $GLOBALS['base_url'] . $value;
});
$twig_environment->addFunction($function);

// register storage_url function
$function = new \Twig\TwigFunction('storage_url', function ($value) {
    return $GLOBALS['base_url'] . 'storage/' . $value;
});
$twig_environment->addFunction($function);

// TODO: Create laravel-mix like function to handle timestamped files
