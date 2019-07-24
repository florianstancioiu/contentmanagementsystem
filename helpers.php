<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

if (! defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (! function_exists('view')) {
    /**
     * @param string $template
     * @param array $data
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    function view(string $template, array $data = []) : string {
        $loader = new Twig\Loader\FilesystemLoader(base_dir('resources' . DS . 'views'));
        $twig = new Twig\Environment($loader, [
            'cache' => base_dir('public' . DS . 'templatecache'),
        ]);

        $template = $twig->load($template);

        echo $template->render($data);
    }
}

if (! function_exists('read_json_file')) {
    /**
     * @param string $file_path
     * @return array
     */
    function read_json_file(string $file_path) : array {
        try {
            $contents = file_get_contents($file_path);
            $array = json_decode($contents, true);
        } catch (Throwable $e) {
            return [];
        }

        return is_null($array) ? [] : $array;
    }
}

if (! function_exists('base_dir')) {
    /**
     * @return string
     */
    function base_dir() : string {
        return dirname(getcwd());
    }
}

if (! function_exists('dd')) {
    /**
     * @param mixed ...$data
     */
    function dd(... $data) {
        echo '<pre>';
        foreach ($data as $entry) {
            print_r($entry);
            echo '<br/>';
        }
        echo '</pre>';
        exit();
    }
}
