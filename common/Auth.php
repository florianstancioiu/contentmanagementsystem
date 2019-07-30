<?php

namespace Common;

use \PDOException;

class Auth extends Controller
{
    public function showLogin()
    {
        $login_url = url('/auth/login');

        return view('admin/auth/login.html', compact('login_url'));
    }

    public function loginUser()
    {
        try {
            $data = [
                ':email' => $email,
                ':password' => $password
            ];
            $pdo->prepare('SELECT first_name, last_name, email, password, created_at, updated_at, deleted_at from users where email =:email and :password');
            $statement->execute($data);
        } catch(\PDOException $error) {
            echo 'shit\'s wack yo';
        }

        while ($row = $statement->fetch()) {
            // dd($row);
        }

        $_SESSION['is_logged'] = 'true';
        $_SESSION['user'] = $this->getUserData($email);
    }

    public function login()
    {
        $this->loginUser();

        redirect('/admin');
    }

    public function userExists($email, $password) : bool
    {
        //
    }

    public function showRegister()
    {
        $register_url = url('/auth/register');

        return view('admin/auth/register.html', compact('register_url'));
    }

    public function register()
    {
        // validate the variables ffs
        $first_name = post('first_name');
        $last_name = post('last_name');
        $email = post('email');
        $password = post('password');
        $created_at = post('created_at');

        try {
            $data = [
                ':first_name' => $first_name,
                ':last_name' => $last_name,
                ':email' => $email,
                ':password' => $password,
                ':created_at' => $created_at,
            ];
            $pdo->prepare('INSERT INTO users (first_name, last_name, email, password, created_at) VALUES (:first_name, :last_name, :email, :password, :created_at)');
            $statement->execute($data);
        } catch (\PDOException $error) {
            echo 'shit\'s wack yo';
        }

        $this->loginUser();

        redirect('/admin');
    }
}