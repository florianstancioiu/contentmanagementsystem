<?php

namespace Common;

use \PDOException;

// TODO: Refactor class
// TODO: Move SQL queries to User model
class Auth extends Controller
{
    public function showSignin()
    {
        $this->redirectAdmin();

        $signin_url = url('/signin');

        return view('admin/auth/signin', compact('signin_url'));
    }

    public function signinUser()
    {
        $statement = $this->pdo->prepare('SELECT id, first_name, last_name, email, password, created_at from users where email = :email');

        try {
            $statement->execute([
                ':email' => post('email')
            ]);
        } catch (PDOException $error) {
            dd($error->getMessage());
        }

        $data = $statement->fetchObject();
        $array_data = get_object_vars($data);
        $raw_password = post('password');
        $password_hash = $array_data['password'];

        // verify password hash
        if (password_verify($raw_password, $password_hash)) {
            $_SESSION['is_logged'] = true;
            $_SESSION['user'] = $array_data;
        }
    }

    public function signin()
    {
        $this->signinUser();

        $this->redirectAdmin();
    }


    public function getUserData(string $email)
    {
        //
    }

    public function userExists($email, $password) : bool
    {
        //
    }

    public function showSignup()
    {
        $this->redirectAdmin();

        $signup_url = url('/signup');

        return view('admin/auth/signup', compact('signup_url'));
    }


    public function signup()
    {
        if ($this->emailExistsInDatabase()) {
            redirect('/register', [
                'message' => 'The email address you typed-in exists in database'
            ]);
        }

        // validate the variables ffs
        $data = [
            ':first_name' => post('first_name'),
            ':last_name' => post('last_name'),
            ':email' => post('email'),
            ':password' => password_hash(post('password'), PASSWORD_BCRYPT)
        ];

        try {
            $statement = $this->pdo->prepare('INSERT INTO users (first_name, last_name, email, password, created_at) VALUES (:first_name, :last_name, :email, :password, NOW())');
            $statement->execute($data);
        } catch (PDOException $error) {
            dd($error->getMessage());
        }

        redirect('/admin');
    }

    public function emailExistsInDatabase() : bool
    {
        // check email address existence in database
        $statement = $this->pdo->prepare('SELECT first_name, email from users where email = :email');

        try {
            $statement->execute([
                ':email' => post('email')
            ]);
        } catch (PDOException $error) {
            dd($error->getMessage());
        }

        $data = $statement->fetchObject();

        return (bool) $data->email === post('email');
    }

    public function signout()
    {
        unset($_SESSION['is_logged']);
        unset($_SESSION['user']);

        redirect('/signin');
    }
}