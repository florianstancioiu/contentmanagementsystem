<?php

namespace Common;

use \Exception;

// TODO: Generate csrf_tokens to use in forms
// TODO: Create FORM-REQUEST classes (like in Laravel) to handle form validation
class Controller
{
    // a list of existing methods checked for authentication
    protected static $auth_methods = [];

    public function __construct()
    {
        $this->validAuthMethods();
    }

    protected function validAuthMethods()
    {
        $class_name = static::class;
        foreach (static::$auth_methods as $method) {
            if (! method_exists($class_name, $method)) {
                throw new \Exception("The $method method doesn't exist on $class_name class");
            }
        }
    }

    // Check user authentication automatically
    // TODO: Update the darn thing to use a class container
    public function __call(string $method, array $params)
    {
        $class_name = static::class;

        if (in_array($method, static::$auth_methods)) {
            // check if user is logged in
            self::checkAuth();
        }

        if (! method_exists($class_name, $method)) {
            throw new \Exception("The $method method doesn't exist on $class_name class");
        }

        return call_user_func_array([ new $class_name, $method ], $params);
    }

    // Check if the current user is authenticated
    protected static function checkAuth()
    {
        $data = [
            'message' => 'You have to login in order to use the website'
        ];

        if (! is_logged_in()) {
            redirect('/signin', $data);
        }
    }

    public function redirectAdmin()
    {
        if (is_logged_in()) {
            redirect('/admin');
        }
    }
}
