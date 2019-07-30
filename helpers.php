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
            // dont use the cache
            // 'cache' => base_dir('public' . DS . 'templatecache'),
        ]);

        $template = ($twig->load($template_name));

        $data['base_url'] = url();

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

if (! function_exists('url')) {
    /**
     * @param string $url_path
     * @return string
     */
    function url(string $url_path = '') : string {
        // trim the leading slash
        if (strpos($url_path, '/') === 0) {
            $url_path = substr($url_path, 1);
        }

        $data = read_json_file(base_dir() . DS . '.env');

        return $data['base_url'] . $url_path;
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

if (! function_exists('redirect')) {
    /**
     * @param string $route
     */
    function redirect(string $route) {
        // trim the leading slash
        if (strpos($route, '/') === 0) {
            $route = substr($route, 1);
        }

        if (! strpos($route, base_url()) === 0) {
            $location = base_url() . '/' . $route;
        }

        header("Location: $location");
    }
}

if (! function_exists('request')) {
    /**
     * @param string $name
     * @param string|null $value
     * @return mixed
     */
    function request(string $name, string $value = null) {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        }

        if (isset($_GET[$name])) {
            return $_GET[$name];
        }
    }
}

if (! function_exists('post')) {
    /**
     * @param string $name
     * @param $value
     * @return mixed
     */
    function post(string $name, $value) {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        } else {
            $_POST[$name] = $value;
        }
    }
}

if (! function_exists('get')) {
    /**
     * @param string $name
     * @param $value
     * @return mixed
     */
    function get(string $name, $value) {
        if (isset($_GET[$name])) {
            return $_GET[$name];
        } else {
            $_GET[$name] = $value;
        }
    }
}