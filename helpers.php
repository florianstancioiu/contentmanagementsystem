<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * @param string $template
 * @param array $data
 */
if (! function_exists('view')) {
    function view(string $template, array $data) {
        // Load Twig templates
        $loader = new Twig\Loader\FilesystemLoader('./resources/views');

        $twig = new Twig\Environment($loader, [
            'cache' => './public/templatecache',
        ]);

        $template = $twig->load($template);

        echo $template->render($data);
    }
}
