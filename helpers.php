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
            'debug' => true,
            // dont use the cache
            // 'cache' => base_dir('public' . DS . 'templatecache'),
        ]);

        $template_name = str_replace('.html', '', $template_name);
        $template_name = $template_name . '.html';

        $template = ($twig->load($template_name));

        // retrieve env data for blade views
        $env_data = read_json_file(base_dir() . DS . '.env');

        // remove sensitive env data keys
        foreach ($env_data as $key => $value) {
            if (strpos($key, "db") === 0) {
                unset($env_data[$key]);
            }
        }

        // merge env data with passed information
        $data = array_merge($data, $env_data);

        // retrieve current User data
        if (isset($_SESSION['user'])) {
            $data['user'] = $_SESSION['user'];
        }

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

        return base_url() . $url_path;
    }
}

if (! function_exists('base_url')) {
    /**
     * @return string
     */
    function base_url() : string {
        $data = read_json_file(base_dir() . DS . '.env');

        return $data['base_url'];
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
     * @param array $get_data
     */
    function redirect(string $route, array $get_data = []) {
        $base_url = base_url();

        // trim the leading slash
        if (strpos($route, '/') === 0) {
            $route = substr($route, 1);
        }

        // pass get data
        if (! empty($get_data)) {
            $route = $route . '?' . http_build_query($get_data);
        }

        // create the full route
        if ((int) strpos($route, $base_url) === 0) {
            $route = $base_url . $route;
        }

        header("Location: $route");
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
    function post(string $name, $value = null) {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        } elseif (! is_null($value)) {
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

if (! function_exists('is_logged_in')) {
    /**
     * @return bool
     */
    function is_logged_in() : bool {
        return (bool) isset($_SESSION['is_logged']) && ($_SESSION['is_logged']) === true;
    }
}