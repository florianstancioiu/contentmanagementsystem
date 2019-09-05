<?php

$loader = new \Twig\Loader\FilesystemLoader(base_dir('resources' . DS . 'views'));
$twig_environment = new \Twig\Environment($loader, [
    'debug' => true,
    'autoload' => true,
    // NOTE: it's a good idea to give up the twig cache
    'cache' => base_dir('public' . DS . 'templatecache'),
]);

$function = new \Twig\TwigFunction('active_route', function ($value) {
    return route() === $value ? 'active-route' : '';
}, $options = [
  // 'is_safe' => true,
  // 'is_variadic' => true,
  // 'is_safe_callback' => true
]);
$twig_environment->addFunction($function);
