<?php

use App\Models\Setting;

if (! defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (! defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

if (! defined('STORAGE_PATH')) {
    define('STORAGE_PATH', BASE_PATH . DS . 'storage');
}

if (! defined('PUBLIC_PATH')) {
    define('PUBLIC_PATH', BASE_PATH . DS . 'public');
}

if (! function_exists('route')) {
    function route() : string {
        $request_uri = $_SERVER['REQUEST_URI'];
        $route = explode('?', $request_uri)[0];

        return strpos($route, '/') === 0 ? substr($route, 1) : $route;
    }
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
        $twig_environment = get_twig_environment();
        $template_name = str_replace('.html', '', $template_name);
        $template_name = $template_name . '.html';
        $template = $twig_environment->load($template_name);

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

        // load base_url into $GLOBALS
        $GLOBALS['base_url'] = $data['base_url'];

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

if (! function_exists('env')) {
    /**
    * @return string
    */
    function env(string $key) : ?string {
        // TODO: figure a way to load the env data into $_SESSION
        $data = read_json_file(base_dir() . DS . '.env');

        return isset($data[$key]) ? $data[$key] : null;
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

// TODO: Add a third param to point out how you pass data ($_GET or $_SESSION)
if (! function_exists('redirect')) {
    /**
     * @param string $route
     * @param array $data
     */
    function redirect(string $route, array $data = []) {
        $base_url = base_url();

        // Trim the leading slash
        if (strpos($route, '/') === 0) {
            $route = substr($route, 1);
        }

        // Pass data
        $route = ! empty($data) ? $route . '?' . http_build_query($data) : $route;

        // Create the full route
        if ((int) strpos($route, $base_url) === 0) {
            $route = $base_url . $route;
        }

        header("Location: $route");
        exit();
    }
}

if (! function_exists('redirect_with_errors')) {
    /**
     * @param string $route
     * @param mixed $errors
     */
     function redirect_with_errors(string $route, $errors = []) {
         if (is_array($errors)) {
             return redirect($route, ['errors' => $errors]);
         }

         return redirect($route, ['error' => $errors]);
     }
}

// TODO: handle $value parameter
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

        return null;
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

if (! function_exists('str_slug')) {
    /**
    * @return string
    */
    function str_slug(string $string) {
        $string = urlencode($string);
        $string = htmlentities($string, ENT_QUOTES | ENT_XML1, 'UTF-8');
        $search  = [ '.', '/', ',', ';', '?', '$', '%' ];

        return str_replace($search, '', $string);
    }
}

if (! function_exists('file_error_ok')) {
    /**
    * @return boolean
    */
    function file_error_ok(string $file_name) : bool {
        return (bool) is_array($_FILES[$file_name]) && $_FILES[$file_name]['error'] === UPLOAD_ERR_OK;
    }
}

if (! function_exists('pagination_url')) {
    /**
    * @return string
    */
    function pagination_url(int $index, array $filters) : string {
        if ($index !== 0) {
            $filters['page'] = $index;
        }

        $route = sizeof($filters) > 0 ? route() . "?" : route();

        return url($route . http_build_query($filters));
    }
}

if (! function_exists('create_storage_symlink')) {
    function create_storage_symlink() {
        $storage_symlink = PUBLIC_PATH . DS . 'storage';
        if (! file_exists($storage_symlink)) {
            if (! is_link($storage_symlink)) {
                symlink(STORAGE_PATH, $storage_symlink);
            }
        }
    }
}

if (! function_exists('get_twig_environment')) {
    function get_twig_environment() {
        if (! empty($GLOBALS['twig_environment'])) {
            return $GLOBALS['twig_environment'];
        }

        $loader = new \Twig\Loader\FilesystemLoader(base_dir('resources' . DS . 'views'));
        $GLOBALS['twig_environment'] = new \Twig\Environment($loader, [
            'debug' => true,
            'autoload' => true,
            // NOTE: it's a good idea to give up the twig cache
            'cache' => base_dir('public' . DS . 'templatecache'),
        ]);

        return $GLOBALS['twig_environment'];
    }
}

if (! function_exists('register_routes')) {
    function register_routes() {
        // Require the routes
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

        $route_info = $dispatcher->dispatch($httpMethod, $uri);

        switch ($route_info[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $route_info[1];
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $route_info[1];
                $vars = $route_info[2];



                // make the anonymous functions work
                if (is_object($handler)) {
                    call_user_func($handler, $vars);
                }

                // make the classes work
                list($class, $method) = explode("@", $handler, 2);

                try {
                    call_user_func_array(array(new $class, $method), $vars);
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }

                break;
        }
    }
}

if (! function_exists('init_twig_extensions')) {
    function init_twig_extensions() {
        (new \Common\Twig());
    }
}

// TODO: Create function(s) to handle session data
// TODO: Create function to handle GET and SESSION filters
