<?php

namespace Common;

use \PDOException;
use Admin\Models\User;

// TODO: Refactor class
// TODO: Move SQL queries to User model
class Auth extends Controller
{
    public function signin()
    {
        User::signin();
    }

    public function showSignin()
    {
        $this->redirectAdmin();

        $signin_url = url('/signin');

        return view('admin/auth/signin', compact('signin_url'));
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
        User::signup();
    }

    public function signout()
    {
        unset($_SESSION['is_logged']);
        unset($_SESSION['user']);

        redirect('/signin');
    }
}