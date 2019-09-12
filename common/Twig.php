<?php

// TODO: Create laravel-mix like function to handle timestamped files
// TODO: Create translation function to handle language translations

$loader = new \Twig\Loader\FilesystemLoader(base_dir('resources' . DS . 'views'));
$twig_environment = new \Twig\Environment($loader, [
    'debug' => true,
    'autoload' => true,
    // NOTE: it's a good idea to give up the twig cache
    'cache' => base_dir('public' . DS . 'templatecache'),
]);

// register active_route function
$function = new \Twig\TwigFunction('active_route', function ($value) {
    $route = route();

    // remove leading forward slash
    if (strpos($value, '/') === 0) {
        $value = substr($value, 1);
    }

    // prevent strpos error
    if (strlen($value) === 0) {
        return $route === $value ? 'active-route' : '';
    }

    return strpos($route, $value) === 0 ? 'active-route' : '';
});
$twig_environment->addFunction($function);

// register url function
$function = new \Twig\TwigFunction('url', function ($value = '/') {
    $base_url = $GLOBALS['base_url'];

    // remove leading forward slash
    if (strpos($value, '/') === 0) {
        $value = substr($value, 1);
    }

    return $base_url . $value;
});
$twig_environment->addFunction($function);

// register storage_url function
$function = new \Twig\TwigFunction('storage_url', function ($value) {
    $base_url = $GLOBALS['base_url'];

    // remove leading forward slash
    if (strpos($value, '/') === 0) {
        $value = substr($value, 1);
    }

    return $base_url . 'storage/' . $value;
});
$twig_environment->addFunction($function);

// TODO: Create is_authenticated function to check if there is anybody logged in
$function = new \Twig\TwigFunction('is_authenticated', function () {
    // TODO: actually implement the darn thing
    return (bool) rand(0, 1);
});
$twig_environment->addFunction($function);
