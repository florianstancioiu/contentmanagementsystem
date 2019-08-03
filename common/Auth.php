<?php

namespace Common;

use \PDOException;

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
        $statement = $this->pdo->prepare('SELECT first_name, last_name, email, password, created_at from users where email = :email');

        try {
            $statement->execute([
                ':email' => post('email')
            ]);
        } catch (PDOException $error) {
            dd($error->getMessage());
        }

        $data = $statement->fetchObject();
        $array_data = get_object_vars($data);
        unset($array_data['password']);

        // check if the password hash matches your current password
        if (password_verify(post('password'), $data->password)) {
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
}