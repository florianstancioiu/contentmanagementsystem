<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

if (! defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (! function_exists('view')) {
    /**
     * @param string $template_name
     * @param array $data
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    function view(string $template_name, array $data = []) {
        $loader = new Twig\Loader\FilesystemLoader(base_dir('resources' . DS . 'views'));
        $twig = new Twig\Environment($loader, [
            'cache' => base_dir('public' . DS . 'templatecache'),
        ]);

        $template = ($twig->load($template_name));

        echo $template->render(['a_variable' => 'some stuff']);
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
     * @param string $path
     * @return string
     */
    function base_dir(string $path = '') : string {
        if (strpos($path, '/') !== 0) {
            $path = '/' . $path;
        }
        
        return dirname(getcwd()) . $path;
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
