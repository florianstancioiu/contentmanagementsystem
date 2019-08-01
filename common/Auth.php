<?php

namespace Common;

use \PDOException;

class Auth extends Controller
{
    public function showLogin()
    {
        // redirect to admin if logged in
        if (is_logged_in()) {
            return redirect('/admin');
        }

        $login_url = url('/login');

        return view('admin/auth/login', compact('login_url'));
    }

    public function loginUser()
    {
        $statement = $this->pdo->prepare('SELECT first_name, last_name, email, password, created_at from users where email = :email');

        try {
            $statement->execute([
                ':email' => post('email')
            ]);
        } catch (PDOException $error) {
            dd($error->getMessage());
        }

        $data = $statement->fetchObject();

        // check if the password hash matches your current password
        if (password_verify(post('password'), $data->password)) {
            $_SESSION['is_logged'] = 'true';

            $_SESSION['user'] = $this->getUserData(post('email'));
        }

    }

    public function getUserData(string $email)
    {
        //
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
        // redirect to admin if logged in
        if (is_logged_in()) {
            return redirect('/admin');
        }

        $register_url = url('/register');

        return view('admin/auth/register', compact('register_url'));
    }

    public function register()
    {
        // validate the variables ffs
        $data = [
            ':first_name' => post('first_name'),
            ':last_name' => post('last_name'),
            ':email' => post('email'),
            ':password' => password_hash(post('password'), PASSWORD_BCRYPT),
            ':created_at' => post('created_at'),
        ];

        try {
            $statement = $this->pdo->prepare('INSERT INTO users (first_name, last_name, email, password, created_at) VALUES (:first_name, :last_name, :email, :password, NOW())');
            $statement->execute($data);
        } catch (PDOException $error) {
            dd($error->getMessage());
        }

        redirect('/admin');
    }
}